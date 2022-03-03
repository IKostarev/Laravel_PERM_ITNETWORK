<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CityRequest;
use App\Mediators\CityMediator;
use App\Mediators\SingleMediator;
use App\Models\Cities;
use App\Repositories\CityRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CitiesController extends ApiController
{

    // Вариант 1 - DI отдельного класса репозитория
    /**
     * @var CityRepository
     */
    /*private $cityRepository;

    public function __construct(CityRepository $cityRepository) {
        $this->cityRepository = $cityRepository;
    }*/

    // Вариант 2 - DI с использованием посредников под каждую сущность
    /**
     * @var CityMediator
     */
    /*private $cityMediator;

    public function __construct(CityMediator $cityMediator) {
        $this->cityMediator = $cityMediator;
    }*/

    /**
     * @var SingleMediator
     */
    private $mediator;

    public function __construct(SingleMediator $mediator) {
        $this->mediator = $mediator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->mediator->repository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CityRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CityRequest $request)
    {
        // можно в роуте используя middleware can, можно в контроллере
        //$this->authorize('create', Cities::class);

        $city = new Cities($request->validated());
        $city->save();

        return response()->json($city);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $city_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($city_id)
    {
        return response()->json($this->mediator->repository->getById($city_id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CityRequest  $request
     * @param  Cities  $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CityRequest $request, Cities $city)
    {
        $city->fill($request->validated());

        $city->save();

        return response()->json($city);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $city_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($city_id)
    {
        $this->mediator->service->delete($city_id);
        return response()->json([], 204);
    }


    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $city_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($city_id)
    {
        Cities::withTrashed()->where('id', $city_id)->restore();
        $city = Cities::findOrFail($city_id);

        return response()->json($city);
    }
}
