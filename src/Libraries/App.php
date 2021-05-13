<?php

namespace hamkamannan\adminigniter\Libraries;

class App
{
    protected $paramModel;
    protected $logModel;
    public function __construct()
    {
        $this->paramModel = new \hamkamannan\adminigniter\Modules\Core\Param\Models\ParamModel();
        $this->logModel = new \hamkamannan\adminigniter\Models\LogModel();
        
        helper(['url', 'text', 'form', 'auth', 'app', 'html', 'cookie']);
    }

    function addLog($message, $controller = null, $operation = null, $ref_table = null, $ref_id = null)
    {
        $save_data = [
            'message' => $message,
            'controller' => $controller,
            'operation' => $operation,
            'ref_table' => $ref_table,
            'ref_id' => $ref_id,
            'created_by' => user_id(),
        ];

        return $this->logModel->insert($save_data);
    }

    public function getParameter($name, $default = null, $create_param = false)
    {
        if ($param = $this->parameterExists($name)) {
            if (!empty($param)) {
                return $param;
            } else {
                return $default;
            }
        } else {
            if ($create_param) {
                $this->addParameter($name, $default);
            }
        }

        return $default;
    }

    public function addParameter($name =  null, $value = null, $set_cookie = false)
    {
        if ($this->parameterExists($name, $value) === false) {
            $data = array(
                'name' => $name,
                'value' => $value
            );
            $ret = $this->paramModel->insert($data);
            $params = $this->paramModel->findAll();
            if ($set_cookie) {
                set_cookie('params', json_encode($params), 3600 * 24 * 1);
            }
            return $ret;
        }
        return false;
    }

    public function setParameter($name =  null, $value = null, $set_cookie = false)
    {
        if ($this->parameterExists($name, $value) === false) {
            $this->addParameter($name, $value);
        } else {
            $param = $this->paramModel->where('name', $name)->first();
            $data = array(
                'value' => $value
            );
            $ret = $this->paramModel->update($param->id, $data);
            $params = $this->paramModel->findAll();

            if ($set_cookie) {
                set_cookie('params', json_encode($params), 3600 * 24 * 1);
            }
            return $ret;
        }
    }

    public function deleteParam($name =  null)
    {
        $param = $this->paramModel->where('name', $name)->first();
        return $this->paramModel->delete($param->id);
    }

    public function parameterExists($name =  null, $set_cookie = false)
    {
        $params = json_decode(get_cookie('params'));
        if (!$params) {
            $params = $this->paramModel->findAll();

            if ($set_cookie) {
                set_cookie('params', json_encode($params), 3600 * 24 * 1);
            }
        }

        $param = [];

        foreach ($params as $row) {
            $param[$row->name] = $row;
        }
        if (isset($param[$name])) {
            return $param[$name]->value;
        }

        return false;
    }
}
