<?php
declare(strict_types=1);

namespace Core\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AbstractController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $domainRequest;
    protected $domainService;

    public function index(Request $request)
    {
        $this->domainRequest->set($request->all());

        // $this->domainRequest->add('created_by', $request->user()->id);

        $response = $this->domainService->index($this->domainRequest);

        return response()->json(json_decode($response->data(), true), $response->code());
    }

    /**
     * Search in resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $this->domainRequest->set($request->all());
        $this->domainRequest->add('query', $request->get('query'));
        $this->domainRequest->add('per_page', $request->get('per_page'));
        $response = $this->domainService->search($this->domainRequest);

        return response()->json(json_decode($response->data(), true), $response->code());
    }

    public function store(Request $request)
    {
        $this->domainRequest->set($request->all());

        // $this->domainRequest->add('created_by', $request->user()->id);

        $response = $this->domainService->store($this->domainRequest);

        return response()->json(json_decode($response->data(), true), $response->code());
    }

    /**
     * Store a multiple newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeMany(Request $request)
    {
        $this->domainRequest->set($request->all());
        $response = $this->domainService->storeMany($this->domainRequest, '');

        return response()->json(json_decode($response->data(), true), $response->code());
    }

    public function show(Request $request, int $id)
    {
        $this->domainRequest->set($request->all());
        $response = $this->domainService->show($this->domainRequest, $id);
        return response()->json(json_decode($response->data(), true), $response->code());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $this->domainRequest->set($request->all());
        // $this->domainRequest->add('updated_by', $request->user()->id);

        $response = $this->domainService->update($this->domainRequest, $id);

        return response()->json(json_decode($response->data(), true), $response->code());
    }

    /**
     * update Many.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMany(Request $request)
    {
        $this->domainRequest->set($request->all());
        $response = $this->domainService->updateMany($this->domainRequest, '');

        return response()->json(json_decode($response->data(), true), $response->code());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $this->domainRequest->set($request->all());
        // $this->domainRequest->add('updated_by', $request->user()->id);
        $response = $this->domainService->destroy($this->domainRequest, (int)$id);

        return response()->json(json_decode($response->data(), true), $response->code());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $this->domainRequest->set($request->all());
        $response = $this->domainService->filter($this->domainRequest);

        return response()->json(json_decode($response->data(), 1), $response->code());
    }
}
