<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\EmployeeLeaveRequest;
use App\Filament\Resources\EmployeeLeaveRequestResource;
use Saade\FilamentFullCalendar\Data\EventData;
use Carbon\Carbon;
use App\Models\LeaveRequestApprover;
use Auth;
use Log;

class CalendarWidget extends FullCalendarWidget
{

    public function fetchEvents(array $fetchInfo): array
    {
        $approvingPower = collect(LeaveRequestApprover::query()->where('user_id', Auth::user()->id)->get(['department_id']));
        return EmployeeLeaveRequest::from('employee_leave_requests as elr')
            ->join('employees as e', 'e.id', 'elr.employee_id')
            ->where('elr.start_date', '>=', $fetchInfo['start'])
            ->where('elr.end_date', '<=', $fetchInfo['end'])
            ->whereIn('e.department_id', $approvingPower)
            ->select('elr.*')
            ->get()
            ->map(
                fn (EmployeeLeaveRequest $event) => EventData::make()
                    ->id($event->id)
                    ->title($event->employee->name . " [" . $event->status . "]")
                    ->start($event->start_date)
                    ->end(str_replace('12a', '', Carbon::parse($event->end_date)->addDays(1)))
                    ->borderColor("#000000")
                    ->textColor(
                        match($event->status) {
                            'For Approval', 'Approved'  =>  "#000000",
                            'Rejected'      =>  "#ffffff",
                            default => null
                        })
                    ->backgroundColor(
                            match($event->status) {
                                'For Approval'  =>  "#19dcdb",
                                'Approved'      =>  "#1cb139",
                                'Rejected'      =>  "#e51d38",
                                default => null
                            })
                    ->url(
                        url: EmployeeLeaveRequestResource::getUrl(name: 'edit', parameters: ['record' => $event]),
                        shouldOpenUrlInNewTab: false
                    )
            )
            ->toArray();
    }

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'displayEventTime' => false,
            'eventDisplay' => 'block',
            'headerToolbar' => [
                'left' => 'dayGridWeek,dayGridDay',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
            
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
            function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){

            }
        JS;
    }
}
