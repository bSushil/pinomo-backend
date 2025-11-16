<?php
namespace Main\Modules\Acl\Controllers\Front;

use Illuminate\Http\Request;
use Core\Controllers\WebAbstractController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Main\Modules\Acl\Requests\RoleCreateRequest;
use Main\Modules\Acl\Requests\RoleRequest;
use Main\Modules\Acl\Requests\RoleUpdateRequest;
use Main\Modules\Acl\Services\PermissionService;
use Main\Modules\Acl\Services\RoleService;

/**
 * RoleController
 */
class RoleController extends WebAbstractController
{
    private $pmService;
    
    /**
     * __construct
     *
     * @param RoleService $service
     * @param RoleRequest $request
     */
    /**
     * @return void
     */
    public function __construct(RoleService $service, RoleRequest $request, PermissionService $pmService)
    {
        $this->domainService = $service;
        $this->domainRequest = $request;
        $this->pmService = $pmService;
    }

    public function index(): View
    {
        if (!Gate::allows('role.list')) {
            abort(403);
        }
        return view('roles.index');
    }

    /**
     * view
     *
     * @param  int     $id
     * @param  Request $request
     * @return View
     */
    public function view(int $id, Request $request): View
    {
        $this->domainRequest->set($request->all());
        $response = $this->domainService->show($this->domainRequest, $id);
        return view('roles.view', ['data' => $response->getData()]);
    }
        
    /**
     * edit
     *
     * @param  int     $id
     * @param  Request $request
     * @return View
     */
    public function edit(int $id, Request $request): View
    {
        if (!Gate::allows('role.update')) {
            abort(403);
        }

        $this->domainRequest->set($request->all());
        $this->domainRequest->add('with', ['permissions']);
        $permissionsList = $this->pmService->getPermissions();
        $response = $this->domainService->show($this->domainRequest, $id);
        return view('roles.edit', ['data' => $response->getData(), 'permissionsList' => $permissionsList]);
    }
    
    /**
     * update
     *
     * @param  int               $id
     * @param  RoleUpdateRequest $request
     * @return void
     */
    public function update(int $id, RoleUpdateRequest $request)
    {
        if (!Gate::allows('role.update')) {
            abort(403);
        }
        
        $this->domainRequest->set($request->all());
        $response = $this->domainService->update($this->domainRequest, $id, false);
        if (200 == $response->code()) {
            return redirect(route('roles.index'));
        }
    }
    
    /**
     * create
     *
     * @param  Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!Gate::allows('role.save')) {
            abort(403);
        }
        
        $permissionsList = $this->pmService->getPermissions();
        return view('roles.create', compact('permissionsList'));
    }
    
    /**
     * store
     *
     * @param  RoleCreateRequest $request
     * @return void
     */
    public function store(RoleCreateRequest $request)
    {
        if (!Gate::allows('role.save')) {
            abort(403);
        }
        
        $this->domainRequest->set($request->all());

        $response = $this->domainService->storeRole($this->domainRequest);

        if (200 == $response->code()) {
            return redirect(route('roles.index'));
        }
        return redirect(route('role.create'))->withErrors($response->getData());
    }
    
    /**
     * destroy
     *
     * @param  int     $id
     * @param  Request $request
     * @return void
     */
    public function destroy(int $id, Request $request)
    {
        if (!Gate::allows('role.delete')) {
            abort(403);
        }
        
        $this->domainRequest->set($request->all());
        $response = $this->domainService->destroy($this->domainRequest, $id);
        return redirect(route('roles.index'));
    }
}