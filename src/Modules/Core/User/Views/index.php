<?= $this->extend('\hamkamannan\adminigniter\Views\layout\backend\main'); ?>
<?= $this->section('page'); ?>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display1 icon-gradient bg-strong-bliss"></i>
                </div>
                <div>Dashboard
                    <div class="page-title-subheading">Dashboard</div>
                </div>
            </div>
            <div class="page-title-actions">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('auth') ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active breadcrumb-item" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">Users</div>
                            <div class="widget-subheading">Total All Users</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers"><span>11</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">Active Users</div>
                            <div class="widget-subheading">Total Active Users</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers"><span>10</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">Inactive Users</div>
                            <div class="widget-subheading">Total Inactive Users</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers"><span>1</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">Groups</div>
                            <div class="widget-subheading">Total All Groups</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers"><span>2</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="divider mt-0" style="margin-bottom: 30px;"></div>
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card mb-3 widget-content bg-arielle-smile">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-left">
                            <div class="widget-heading">Users</div>
                            <div class="widget-subheading">Total All Users</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers"><span>11</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card mb-3 widget-content bg-happy-green">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-left">
                            <div class="widget-heading">Active Users</div>
                            <div class="widget-subheading">Total Active Users</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers"><span>10</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card mb-3 widget-content bg-warm-flame">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-left">
                            <div class="widget-heading">Inactive Users</div>
                            <div class="widget-subheading">Total Inactive Users</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers"><span>1</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card mb-3 widget-content bg-premium-dark">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-left">
                            <div class="widget-heading">Groups</div>
                            <div class="widget-subheading">Total All Groups</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers"><span>2</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Users</div>
                                                <div class="widget-subheading">Total All Users</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-success">500</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Active User</div>
                                                <div class="widget-subheading">Total Active Users</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-primary">100</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Inactive Users</div>
                                                <div class="widget-subheading">Total Inactive Users</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-danger">400</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Groups</div>
                                                <div class="widget-subheading">Total All Groups</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-warning">10</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="card-hover-shadow-2x mb-3 card">
                    <div class="card-header">Activity Log</div>
                    <div class="scroll-area-sm">
                        <div class="scrollbar-container ps ps--active-y">
                            <div class="p-2">
                                <ul class="todo-list-wrapper list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="todo-indicator bg-warning"></div>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-2">
                                                    <div class="custom-checkbox custom-control"><input type="checkbox" id="exampleCustomCheckbox12" class="custom-control-input"><label class="custom-control-label" for="exampleCustomCheckbox12">&nbsp;</label>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Activity 1
                                                        <div class="badge badge-danger ml-2">Rejected</div>
                                                    </div>
                                                    <div class="widget-subheading"><i>Description </i></div>
                                                </div>
                                                <div class="widget-content-right widget-content-actions">
                                                    <button class="border-0 btn-transition btn btn-outline-success">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                    <button class="border-0 btn-transition btn btn-outline-danger">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="todo-indicator bg-focus"></div>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-2">
                                                    <div class="custom-checkbox custom-control"><input type="checkbox" id="exampleCustomCheckbox1" class="custom-control-input"><label class="custom-control-label" for="exampleCustomCheckbox1">&nbsp;</label>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Activity 2</div>
                                                    <div class="widget-subheading">
                                                        <div>Description
                                                            <div class="badge badge-pill badge-info ml-2">NEW</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right widget-content-actions">
                                                    <div class="d-inline-block dropdown">
                                                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="border-0 btn-transition btn btn-link">
                                                            <i class="fa fa-ellipsis-h"></i>
                                                        </button>
                                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                            <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                            <button type="button" disabled="" tabindex="-1" class="disabled dropdown-item">Action</button>
                                                            <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                            <div tabindex="-1" class="dropdown-divider"></div>
                                                            <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="todo-indicator bg-primary"></div>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-2">
                                                    <div class="custom-checkbox custom-control"><input type="checkbox" id="exampleCustomCheckbox4" class="custom-control-input"><label class="custom-control-label" for="exampleCustomCheckbox4">&nbsp;</label>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">Activity 3</div>
                                                    <div class="widget-subheading">Description</div>
                                                </div>
                                                <div class="widget-content-right widget-content-actions">
                                                    <button class="border-0 btn-transition btn btn-outline-success">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </div>
                                                <div class="widget-content-right ml-3">
                                                    <div class="badge badge-pill badge-success">Latest Task</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="todo-indicator bg-info"></div>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-2">
                                                    <div class="custom-checkbox custom-control"><input type="checkbox" id="exampleCustomCheckbox2" class="custom-control-input"><label class="custom-control-label" for="exampleCustomCheckbox2">&nbsp;</label>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="42" class="rounded" src="http://localhost:8080/themes/uigniter/images/avatars/1.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Activity 4</div>
                                                    <div class="widget-subheading">Description</div>
                                                </div>
                                                <div class="widget-content-right widget-content-actions">
                                                    <button class="border-0 btn-transition btn btn-outline-success">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                    <button class="border-0 btn-transition btn btn-outline-danger">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="todo-indicator bg-success"></div>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-2">
                                                    <div class="custom-checkbox custom-control"><input type="checkbox" id="exampleCustomCheckbox3" class="custom-control-input"><label class="custom-control-label" for="exampleCustomCheckbox3">&nbsp;</label>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">Activity 5</div>
                                                    <div class="widget-subheading">Descrtiption</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="badge badge-warning mr-2">69</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <button class="border-0 btn-transition btn btn-outline-success">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                    <button class="border-0 btn-transition btn btn-outline-danger">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps__rail-y" style="top: 0px; height: 200px; right: 0px;">
                                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 58px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="d-block text-right card-footer">
                        <button class="mr-2 btn btn-link btn-sm">Cancel</button>
                        <button class="btn btn-primary">Add Task</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection('page'); ?>