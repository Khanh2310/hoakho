
<link rel="stylesheet" href="{{ asset('public/font_end/custom_chatbox/chatbox_css.css') }}">
<div id="chat-circle" class="btn btn-raised">
    <div id="chat-overlay"></div>
        <i class="material-icons">Nhắn tin</i>
</div>

<div class="chat-box">
    <div class="chat-box-header">
    <span class="chat-box-header--text">Hộp thoại</span>
    <span class="chat-box-toggle"><img src="{{ asset('public/upload/close.svg') }}" alt="" style="width: 18px; height: 18px;"></span>
    </div>
    <div class="chat-box-body">
    <div class="chat-box-overlay">
    </div>
    <div class="chat-logs">

    </div><!--chat-log -->
    </div>
    <div class="chat-input">
    <form>
        <input type="text" id="chat-input" placeholder="Gửi tin nhắn..."/>
    <button type="submit" class="chat-submit" id="chat-submit"><img src="{{ asset('public/upload/send-button.svg') }}" alt="" style="width: 24px; height: 24px;"></button>
    </form>
    </div>
</div>
<script src="{{ asset('public/font_end/custom_chatbox/chatbox_js.js') }}"></script>
