<?php
declare(strict_types=1);

namespace Core\Services;

use Core\Contracts\Request\Request;
use Core\Contracts\Response\Response;
use Core\Exceptions\AuthenticationException;
use Core\Exceptions\ValidationException;

class AbstractService
{
    protected $repository;
    protected $response;
    protected $validator;
    protected $model;
    protected $authenticator;

    public function index(Request $request): Response
    {
        try{
            if ($this->authenticator != null) {
                $this->authenticator->authenticate();
            }
            $data = $this->repository->index($request->get());
            $this->response->setData($data->toArray());
        } catch(AuthenticationException $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getStatusCode());
        } catch(\Exception $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getCode());
        }
        return $this->response;
    }

    /**
     * search.
     *
     * @param  Request $request
     * @return Response
     */
    public function search(Request $request, $validate=true): Response
    {
        try{
            if ($this->authenticator != null) {
                $this->authenticator->authenticate();
            }
            if ($validate) {
                $this->validator->search()->validate($request);
            }

            $data = $this->repository->search($request->get());
            $this->response->setData($data->toArray());
    
        } catch(AuthenticationException $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getStatusCode());
        } catch(\Exception $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getCode());
        }
        return $this->response;
    }

    public function store(Request $request, $validate=true): Response
    {
        try{
            if ($this->authenticator != null) {
                $this->authenticator->authenticate();
            }

            if ($validate) {
                $this->validator->store()->validate($request);
            }

            $result = $this->repository->store($request->getDataForModel(), $request->get());
            $this->response->setData($result->toArray());
        } catch(AuthenticationException $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getStatusCode());
        } catch(ValidationException $e) {
            $this->response->setData(['error'=>$e->errors()]);
            $this->response->setCode($e->getStatusCode());
        } catch(\Exception $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode(400);
        }
        //Tracking and Store log when create
        // $this->logAction((int)$request->get('created_by'), $data['id'], 'create');

        return $this->response;
    }

    /**
     * storeMany.
     *
     * @param  Request $request
     * @param  string  $relation
     * @return Response
     */
    public function storeMany(Request $request, string $relation): Response
    {
        try{
            if ($this->authenticator != null) {
                $this->authenticator->authenticate();
            }
            $this->validator->storeMany()->validate($request);
            $data = $request->get('data');
            $data = $this->repository->storeMany($request->get(), $relation);
            $this->response->setData($data->toArray());
        } catch(AuthenticationException $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getStatusCode());
        } catch(\Exception $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode(400);
        }

        return $this->response;
    }

    /**
     * show.
     *
     * @param  Request $request
     * @param  $id
     * @return Response
     */
    public function show(Request $request, int $id): Response
    {
        try{
            if ($this->authenticator != null) {
                $this->authenticator->authenticate();
            }
            $data = $this->repository->show($request->get(), $id);
            $this->response->setData($data->toArray());
        } catch(AuthenticationException $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getStatusCode());
        } catch(\Exception $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode(400);
        }

        return $this->response;
    }

    public function update(Request $request, int $id, $validate=true): Response
    {
        try{
            if ($this->authenticator != null) {
                $this->authenticator->authenticate();
            }

            if ($validate) {
                $this->validator->update()->validate($request);
            }

            $data = $this->repository->update($request->getDataForModel(), $request->get(), $id);
            $this->response->setData($data->toArray());
        } catch(AuthenticationException $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getStatusCode());
        } catch(ValidationException $e) {
            $this->response->setData(['error'=>$e->errors()]);
            $this->response->setCode($e->getStatusCode());
        } catch(\Exception $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode(400);
        }

        //Tracking and Store log when update
        // $this->logAction((int)$request->get('updated_by'), $id, 'update');

        return $this->response;
    }

    /**
     * Update Many.
     *
     * @param Request $request
     * @param string  $relation
     */
    public function updateMany(Request $request, string $relation)
    {
        try{
            if ($this->authenticator != null) {
                $this->authenticator->authenticate();
            }
            $this->validator->updateMany()->validate($request);
            $data = $request->get('data');
    
            foreach ($data as $row){
                $this->validator->update()->validate($request->set($row));
            }
    
            $data = $this->repository->updateMany($request->getDataForModel(), $request->get());
        } catch(AuthenticationException $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getStatusCode());
        } catch(\Exception $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode(400);
        }

        $this->response->setData($data->toArray());
    }

    /**
     * Filter.
     *
     * @param  Request $request
     * @return Response
     */
    public function filter(Request $request): Response
    {
        try{
            if ($this->authenticator != null) {
                $this->authenticator->authenticate();
            }
            $data = $this->repository->filter($request->getDataForModel(), $request->get());
            $this->response->setData($data->toArray());
        } catch(AuthenticationException $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getStatusCode());
        } catch(\Exception $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getCode());
        }

        return $this->response;
    }

    /**
     * destroy.
     *
     * @param  int     $id
     * @param  Request $request
     * @return Response
     */
    public function destroy(Request $request, int $id): Response
    {
        try{
            if ($this->authenticator != null) {
                $this->authenticator->authenticate();
            }
            $this->repository->startTransaction();
            try {
                $data = [$this->repository->destroy($id)];
            } catch(\Exception $e) {
                $this->repository->rollbackTransaction();
            }
            $this->repository->endTransaction();
    
            //Tracking and Store log when create
            // $this->logAction((int)$request->get('updated_by'), $id, 'delete');
    
            $this->response->setData($data);
        } catch(AuthenticationException $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getStatusCode());
        } catch(\Exception $e) {
            $this->response->setData(['error'=>$e->getMessage()]);
            $this->response->setCode($e->getCode());
        }

        return $this->response;
    }
}