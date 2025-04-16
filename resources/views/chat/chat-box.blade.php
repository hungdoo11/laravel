@php $messages = $messages ?? []; @endphp

<div id="chat-box" style="position: fixed; bottom: 20px; right: 20px; width: 300px; background: white; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 999;">
    <div style="background: #f57921; color: white; padding: 10px; border-top-left-radius: 8px; border-top-right-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
        <span>Chat với Admin</span>
        <button id="toggle-chat" style="background: none; border: none; color: white; font-size: 16px; cursor: pointer;">−</button>
    </div>
    <div id="chat-content" style="height: 250px; overflow-y: auto; padding: 10px;">
        @forelse ($messages as $msg)
        <div>
            <strong>{{ $msg->sender->full_name ?? 'Không rõ' }}:</strong> {{ $msg->message }}
        </div>
        @empty
        <div>Chưa có tin nhắn nào</div>
        @endforelse
    </div>
    <form id="chat-form" method="POST" style="display: flex; border-top: 1px solid #ccc;">
        @csrf
        <input type="hidden" name="receiver_id" value="1">
        <input type="text" name="message" id="message-input" class="form-control" style="border: none; flex: 1;" placeholder="Nhập tin nhắn..." required>
        <button type="submit" style="background: #f57921; color: white; border: none; padding: 10px;">Gửi</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Toggle minimize/expand chat
    $('#toggle-chat').on('click', function() {
        const chatContent = $('#chat-content');
        const chatForm = $('#chat-form');
        const toggleButton = $(this);

        // Toggle visibility of chat content and form
        chatContent.slideToggle();
        chatForm.toggle();

        // Change button text based on state
        if (chatContent.is(':visible')) {
            toggleButton.text('−'); // Minimize icon
        } else {
            toggleButton.text('+'); // Expand icon
        }
    });

    // Existing form submission code
    $('#chat-form').on('submit', function(e) {
        e.preventDefault(); // Ngăn reload trang

        let message = $('#message-input').val();
        let receiver_id = $('input[name="receiver_id"]').val();
        let token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('chat.send') }}",
            method: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                receiver_id: 1,
                message: $('#message-input').val()
            },
            success: function(response) {
                if (response.success) {
                    let newMessage = `<div><strong>${response.sender}:</strong> ${response.message}</div>`;
                    $('#chat-content').append(newMessage);
                    $('#message-input').val('');
                    $('#chat-content').scrollTop($('#chat-content')[0].scrollHeight);
                }
            },
            error: function(xhr) {
                alert("Có lỗi xảy ra khi gửi tin nhắn.");
                console.error(xhr.responseText);
            }
        });
    });
</script>