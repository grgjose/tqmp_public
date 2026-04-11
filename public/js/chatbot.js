function toggleChat() {
    var chatbox = document.getElementById("chatbot");
    if (chatbox.style.display === "none" || chatbox.style.display === "") {
        chatbox.style.display = "block";
    } else {
        chatbox.style.display = "none";
    }
}

function closeChat() {
    document.getElementById("chatbot").style.display = "none";
}

function sendMessage() {
    var input = document.getElementById("chat-input");
    var message = input.value.trim();
    if (message !== "") {
        var chatBody = document.getElementById("chatbot-body");
        var userMessage = document.createElement("div");
        userMessage.classList.add("chat-message", "user");
        userMessage.textContent = message;
        chatBody.appendChild(userMessage);
        input.value = "";
        chatBody.scrollTop = chatBody.scrollHeight;
    }
}

async function sendApiRequest({ url, method = 'GET', headers = {}, body = null, params = {} }) {
    try {
        // Construct URL with query parameters if provided
        const queryString = new URLSearchParams(params).toString();
        const fullUrl = queryString ? `${url}?${queryString}` : url;

        // Prepare request options
        const options = {
            method,
            headers: { 'Content-Type': 'application/json', ...headers },
        };

        if (body && (method === 'POST' || method === 'PUT' || method === 'PATCH')) {
            options.body = JSON.stringify(body);
        }

        // Send request
        const response = await fetch(fullUrl, options);
        const data = await response.json();

        // Check if the response is successful
        if (!response.ok) {
            throw new Error(`Error: ${response.status} - ${data.message || response.statusText}`);
        }

        return data;
    } catch (error) {
        console.error('API Request Failed:', error);
        throw error;
    }
}