<div>

    <h4 class="card-title mb-5">Activity</h4>
    <ul class="list-unstyled activity-wid">
        @foreach ($activities as $activity)
        <li class="activity-list">
            <div class="activity-icon avatar-xs">
                <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                    <i class="mdi mdi-math-log"></i>
                </span>
            </div>
            <div class="d-flex align-items-start">
                <div class="me-3">
                    <h5 class="font-size-14">{{ $activity->created_at->format('d M') }}
                        <i class="mdi mdi-arrow-right text-primary align-middle ms-2"></i>
                    </h5>
                </div>
                <div class="flex-1">
                    <div>
                        <strong>{{ $activity->causer ? $activity->causer->name : 'Unknown User' }}</strong> -
                        {{ $activity->description }}
                    </div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>