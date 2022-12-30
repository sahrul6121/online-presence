<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attendace\CreateAttendanceRequest;
use App\Http\Requests\Attendace\UpdateAttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AttendanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(Request $request)
    {
        $query = Attendance::query();

        if (Auth::user()->role->code !== 'HRD') {
            $query->where('user_id', $request->user_id);
        }

        return AttendanceResource::collection(
            $query->paginate($request->perPage ?? 10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAttendanceRequest $request
     * @return JsonResponse
     */
    public function tapIn(CreateAttendanceRequest $request)
    {
        if ($this->getCurrentAttendanceQuery($request->type)) {
            return response()->json([
                'message' => 'Already tap in',
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }

        $item = new Attendance;

        $item->fill([
            ...$request->validated(),
            'user_id' => Auth::user()->id,
            'date_in' => Carbon::now(),
            'status' => (int) Carbon::now()->format('H') <= 8 ? 'ON_TIME' : 'LATE'
        ]);

        $item->save();

        return response()->json([
            'message' => 'Tap in Success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function tapOut()
    {
        $result = $this->getCurrentAttendanceQuery(null, true);

        if (!$result) {
            return response()->json([
                'message' => 'Data not found, try to tap in before tap out',
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }

        $result->update([
            'date_out' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Tap out Success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return AttendanceResource
     */
    public function show($id)
    {
        $item = Attendance::query()->findOrFail($id);

        return new AttendanceResource($item);
    }

    /**
     * Display the specified resource.
     *
     * @return AttendanceResource
     */
    public function currentAttendance()
    {
        return new AttendanceResource($this->getCurrentAttendanceQuery());
    }

    public function getCurrentAttendanceQuery(string $type = null, bool $isOut = null) {
        $query = Attendance::query()
            ->where(
                'date_in',
                '>=',
                Carbon::now()->startOfDay()
            )
            ->where(
                'date_in',
                '<=',
                Carbon::now()->endOfDay()
            )
            ->where(
                'user_id',
                Auth::user()->id
            );

        if ($isOut) {
            $query->where('date_out', null);
        }

        if ($type) {
            $query->where('type', $type);
        }

        return $query->latest()->first();
    }
}
