<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/indexstyle.css') }}">
    <link rel="icon" href="{{ asset('images/web-icon.png') }}" >
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
        </div>
        
        @foreach($listItems as $listItem)
            <div class="list-item">
                <p>{{ $listItem->name }}</p>
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
                </div>
            </div>
        @endforeach

        <div class="add-item-form">
            <form method="post" action="{{ route('saveItem') }}" accept-charset="UTF-8">
                @csrf
                <input type="text" name="listItem" id="listItem" placeholder="What needs to be done?">
                <button type="submit" id="sub-button">Add Task</button>
            </form>
        </div>
    </div>
</body>
</html>
