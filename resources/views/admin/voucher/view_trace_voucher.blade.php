<div class="pd-20 mb-30">
    <div class="profile-timeline">
        <div class="timeline-month">
            <h5>{{ $title_trace }}</h5>
        </div>
        @if (count($result_trace) > 0)
            <div class="profile-timeline-list">
                <ul>
                    @foreach ($result_trace as $result)
                        <li>
                            <div class="date">
                                {{ date('d/m/Y', strtotime($result->action_time)) }}
                            </div>
                            <div class="task-name">
                                {{ $result->action_name }}
                            </div>
                            <p>
                                {{ $result->action_message }}
                                "
                                <span style="color: blue">
                                    {{ $result->voucher_code }}
                                </span>
                                "
                                bởi
                                "
                                <span style="color: blue">
                                    {{ $result->name_stuff }}
                                </span>
                                "
                            </p>
                            <div class="task-time">{{ date('H:i a', strtotime($result->action_time)) }}</div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="center">Không tìm thấy kết quả nào</div>
        @endif
    </div>
</div>
