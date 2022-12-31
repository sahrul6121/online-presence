<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payroll\UpdatePayrollRequest;
use App\Http\Resources\PayrollResource;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class PayrollController extends Controller
{
    public int $foodFee = 25000;

    public int $vehicleFee = 20000;

    public int $overTimeFee = 30000;

    public function index(Request $request): JsonResource
    {
        $query = Payroll::query();

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        return PayrollResource::collection(
            Payroll::query()->paginate($request->perPage ?? 10)
        );
    }

    public function store()
    {
        $now = Carbon::now()->format('Y-m-d');

        $users = User::query()
            ->whereDoesntHave('payrolls', function ($query) use ($now) {
                $query->whereBetween('date', [$now, $now]);
            })
            ->get();

        foreach ($users as $user) {
            $dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');

            $dateTo = Carbon::now()->endOfMonth()->format('Y-m-d');

            $fee = round($user->base_salary / 22);

            $attendances = Attendance::query()
                ->where('user_id', $user->id)
                ->whereBetween('date_in', [$dateFrom, $dateTo . ' 23:59:59'])
                ->get();

            $workingDayCount = $attendances->where('type', 'NORMAL')->count();

            $subTotal = (int) round($fee * $workingDayCount, 0, PHP_ROUND_HALF_UP);

            $items = Collection::make(
                $this->generateItems(
                    $workingDayCount, $this->calculateOvertime($attendances->where('type', 'OVER_TIME'))
                )
            );

            $totalItem = 0;

            foreach ($items as $item) {
                $totalItem += (int) $item['total'];
            }

            $id = Payroll::query()->insertGetId([
                'user_id' => $user->id,
                'date' => Carbon::now()->format('Y-m-d'),
                'sub_total' => $subTotal,
                'tax' => 0,
                'total' => $subTotal + $totalItem,
                'company' => 'Widyatama',
                'company_address' => 'Jl. Cikutra No.204A, Sukapada, Kec. Cibeunying Kidul, Kota Bandung, Jawa Barat 40125',
                'company_phone' => '+062 2837 474',
                'bank' => $user->bank,
                'bank_account' => $user->bank_account,
                'country' => 'Indonesia',
            ]);

            foreach ($items as $item) {
                $itemModel = new PayrollItem();

                $itemModel->fill([
                    ...$item,
                    'payroll_id' => $id,
                ]);

                $itemModel->save();
            }
        }

        return response()->json([
            'message' => 'Success Generate Payroll'
        ]);
    }

    /**
     * @param Collection<Attendance> $attendances
     * @return object
     */
    public function calculateOvertime(Collection $attendances)
    {
        $totalHour = 0;

        foreach ($attendances as $attendance) {
            $totalHour += Carbon::parse($attendance->date_in)->diffInHours(Carbon::parse($attendance->date_out));
        }

        return (object)[
            'total_hour' => $totalHour,
            'total_fee' => $totalHour * $this->overTimeFee,
        ];
    }

    public function generateItems(int $day, $overTime)
    {
        $items = [];

        $items[] = [
            'subject' => 'Tunjangan Makan',
            'description' => 'Uang untuk tunjangan makan.',
            'rate' => $this->foodFee,
            'day' => $day,
            'total' => $day * $this->foodFee,
        ];

        $items[] = [
            'subject' => 'Tunjangan Perjalanan',
            'description' => 'Uang untuk tunjangan perjalanan.',
            'rate' => $this->vehicleFee,
            'day' => $day,
            'total' => $day * $this->vehicleFee,
        ];

        if ($overTime->total_hour > 0) {
            $items[] = [
                'subject' => 'Lembur',
                'description' => 'Uang untuk bayaran lembur.',
                'rate' => $this->overTimeFee,
                'hours' => $overTime->total_hour,
                'total' => $overTime->total_fee,
            ];
        }

        return $items;
    }

    public function destroy($id)
    {
        $item = Payroll::query()->findOrFail($id);
        $item->delete();

        return response()->json([
            'message' => 'Delete Success',
        ]);
    }

    public function show(int $id): JsonResource
    {
        $item = Payroll::query()->findOrFail($id);

        return new PayrollResource($item);
    }

    public function update(int $id, UpdatePayrollRequest $request): JsonResource
    {
        $payroll = Payroll::query()->findOrFail($id);

        $payroll->update($request->validated());

        PayrollItem::query()
            ->where('payroll_id', $payroll->id)
            ->delete();

        foreach ($request->items as $item) {
            PayrollItem::query()->create([
                'payroll_id' => $id,
                'subject' => $item['subject'],
                'description' => $item['description'],
                'rate' => $item['rate'],
                'hours' => array_key_exists('hours', $item) ? $item['hours'] : 0,
                'day' => array_key_exists('day', $item) ? $item['day'] : 0,
                'total' => $item['total'],
            ]);
        }

        $updatedPayroll = Payroll::query()->find($id);

        $updatedPayroll->update([
            'total' => $updatedPayroll->sub_total + $updatedPayroll->items->sum('total'),
        ]);

        return new PayrollResource($updatedPayroll);
    }
}
