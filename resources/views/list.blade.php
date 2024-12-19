<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/indexstyle.css') }}">
    <link rel="icon" href="{{ asset('images/web-icon.png') }}" >
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>To-Do List</title>
</head>
<body>
    <div class="container">

        <div class="upper">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="quit-toggle">
                    <img src="{{ asset('images/quit.png') }}" alt="Quit">
                </button>   
            </form>
            <h1>My To-Do List</h1>
            <button class="acc-info" onclick="toggleAccountInfo()">
                    <img src="{{ asset('images/acc.png') }}" alt="Account">
            </button>  
        </div>

        <div id="account-modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeAccountModal()">&times;</span>
                <h2>Account Information</h2>
                <div class="modal-body">
                    <p><strong>Username:</strong> {{ Auth::user()->username }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Account Created At:</strong> {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d/m/Y, H:i') }}</p>
                </div>
            </div>
        </div>
        
        @foreach($listItems as $listItem)
            @php
                $isExpired = isDeadlineExpired($listItem->deadline);
                \Log::debug("Item ID: {$listItem->item_id} | Deadline: {$listItem->deadline} | Is Expired: " . ($isExpired ? 'Yes' : 'No'));
            @endphp
            <div class="list-item" data-id="{{ $listItem->item_id }}">
                <div class="task-wrapper">
                    <p>{{ $listItem->name }}</p>
                    <p class="deadline" onclick="showDeadlineOptions('{{ $listItem->item_id }}')" 
                        style="{{ isDeadlineExpired($listItem->deadline) ? 'color: red;' : 'color: black;' }}">
                        @if($listItem->deadline)
                            @php
                                $deadline = \Carbon\Carbon::parse($listItem->deadline);
                                $now = \Carbon\Carbon::now();
                                if ($deadline->isToday()) {
                                    echo 'Today, ' . $deadline->format('H:i');
                                } elseif ($deadline->isTomorrow()) {
                                    echo 'Tomorrow, ' . $deadline->format('H:i');
                                } else {
                                    echo $deadline->format('d/m/Y, H:i');
                                }
                            @endphp
                        @else
                            No deadline
                        @endif
                    </p>

                    <!-- Dropdown for selecting date and time -->
                    <div id="deadline-options-{{ $listItem->item_id }}" class="deadline-options" style="display: none;">
                        <button class="deadline-btn" onclick="showDatePicker('{{ $listItem->item_id }}')">Set Date</button>
                        <button class="deadline-btn" onclick="showTimePicker('{{ $listItem->item_id }}')">Set Time</button>
                        <button class="deadline-btn" id="set-deadline-btn-{{ $listItem->item_id }}" style="display: none;" onclick="setDeadline('{{ $listItem->item_id }}')">Done</button>
                    </div>

                    <!-- Date and time pickers (initially hidden) -->
                    <input type="date" id="date-picker-{{ $listItem->item_id }}" style="display: none;">
                    <input type="time" id="time-picker-{{ $listItem->item_id }}" style="display: none;">
                    <p id="error-message-{{ $listItem->item_id }}" style="display: none; font-size: 10px; color: red;"></p>                
                </div>

                <div class="actions">
                    <form method="post" action="{{ route('markCompl', $listItem->item_id) }}" accept-charset="UTF-8">
                        @csrf
                        <button type="submit" class="btn mark-button {{ $listItem->is_complete ? 'completed-btn' : 'pending-btn' }}">
                            {{ $listItem->is_complete ? '✔️' : '⌛' }}
                        </button>
                    </form>
                    <form method="post" action="{{ route('deleteItem', $listItem->item_id) }}" accept-charset="UTF-8">
                        @csrf   
                        <button type="submit" class="btn del-button">🗑</button>
                    </form>
                    <button class="btn info-button" onclick="toggleInfo('{{ $listItem->item_id }}')">ℹ️</button>
                </div>
                <div id="info-modal-{{ $listItem->item_id }}" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeInfoModal('{{ $listItem->item_id }}')">&times;</span>
                        <h2>Information</h2>
                        <div class="modal-body">
                            <p><strong>Name:</strong> {{ $listItem->name }}</p>
                            <p><strong>Deadline:</strong> {{ $listItem->deadline ? \Carbon\Carbon::parse($listItem->deadline)->format('d/m/Y, H:i') : 'No deadline' }}</p>
                            <p><strong>Created At:</strong> {{ \Carbon\Carbon::parse($listItem->created_at)->format('d/m/Y, H:i') }}</p>
                            <p><strong>Updated At:</strong> {{ \Carbon\Carbon::parse($listItem->updated_at)->format('d/m/Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="add-item-form">
            <form method="post" action="{{ route('saveItem') }}" accept-charset="UTF-8">
                @csrf
                <input type="text" name="listItem" id="listItem" placeholder="What needs to be done?" required>
                <button type="submit" id="sub-button">Add Task</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/deadline.js') }}"></script>
    <script src="{{ asset('js/account-modal.js') }}"></script>
</body>
</html>
