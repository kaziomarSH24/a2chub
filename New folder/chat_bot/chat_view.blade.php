

@extends('layouts.app')

@section('content')

    <style>
        {
            background-color: #f9f9f9;
        }
        .chat-container {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 25%;
            background-color: #f3f3f3;
            padding: 20px;
        }
        .sidebar h3 {
            font-weight: bold;
            color: #333;
        }
        .chat-main {
            width: 75%;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }
        .chat-box {
            flex-grow: 1;
            overflow-y: auto;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
            height: 500px;
        }
        .chat-box .message {
            margin-bottom: 10px;
            display: flex;
        }
        .chat-box .message .avatar {
            width: 40px;
            height: 40px;
            background-color: #efefef;
            border-radius: 50%;
            margin-right: 10px;
        }
        .chat-box .message .text {
            background-color: #f1f1f1;
            border-radius: 12px;
            padding: 10px;
            white-space: pre-line; /* to handle new lines */
        }
        .chat-input {
            margin-top: 10px;
            display: flex;
            align-items: center;
        }
        .chat-input input {
            flex-grow: 1;
            border-radius: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }
        .chat-input button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
        }
    </style>

    <div class="container-fluid chat-container">
         Sidebar 
        <div class="sidebar">
            <h3>A2chub</h3>
            <div class="user-conversations">
                <button class="btn btn-primary btn-block">+ New Conversation</button>
                <div class="conversation mt-3">
                    <h6>New Conversation</h6>
                    <small>0 messages &bull; 2 hours ago</small>
                </div>
            </div>
        </div>

         Main Chat 
        <div class="chat-main">
            <div class="chat-header">
                <h4>A2chub</h4>
                <span>AI Assistant</span>
            </div>

            <div class="chat-box" id="chatBox">
                 User message 
                <div class="message">
                    <div class="avatar"></div>
                    <div class="text">Hey there! Let me help you with your questions today...</div>
                </div>
                 OpenAI Assistant Response will appear here 
            </div>

             Chat Input 
            <div class="chat-input">
                <input type="text" id="userMessage" class="form-control" placeholder="Type your message here...">
                <button id="sendMessage" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sendMessage').on('click', function (e) {
                e.preventDefault();

                let message = $('#userMessage').val().trim();
                if (message === '') {
                    alert('Please enter a message.');
                    return;
                }

                // Append user message to chat
                appendMessage('user', message);

                // Clear input
                $('#userMessage').val('');

                // Send the message to the server via AJAX
                $.ajax({
                    url: '{{ route("chatgpt") }}', // Update with your route name
                    method: 'POST',
                    data: {
                        content: message,
                        model: 'gpt-4o-mini', // Adjust if needed
                        _token: '{{ csrf_token() }}' // CSRF token for Laravel
                    },
                    success: function (response) {
                        // Process and display the response gradually
                        let formattedResponse = formatResponse(response.response);
                        displayResponseGradually(formattedResponse);
                    },
                    error: function (xhr) {
                        // Handle error case
                        alert('Error: ' + xhr.responseJSON.error);
                    }
                });
            });

            // Function to append messages to chat
            function appendMessage(type, message) {
                let messageHtml = `
                    <div class="message">
                        <div class="avatar"></div>
                        <div class="text">${message}</div>
                    </div>
                `;
                $('#chatBox').append(messageHtml);
                $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
            }

            // Function to format response (bold, new lines, lists)
            function formatResponse(text) {
                // Convert **text** to <strong>text</strong>
                text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

                // Convert ### headers to <h3> headers
                text = text.replace(/### (.*?)\n/g, '<h3>$1</h3>');

                // Handle line breaks (\n)
                text = text.replace(/\n/g, '<br>');

                return text;
            }

            // Function to display response gradually (word by word)
            function displayResponseGradually(text) {
                let words = text.split(' ');
                let index = 0;

                let interval = setInterval(function () {
                    if (index < words.length) {
                        $('#chatBox').append(words[index] + ' ');
                        $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
                        index++;
                    } else {
                        clearInterval(interval);
                    }
                }, 100); // Adjust speed of word appearance
            }
        });
    </script>

@endsection
