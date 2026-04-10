document.addEventListener('DOMContentLoaded', () => {
  "use strict";

  // ===== GEMINI API CONFIG =====
  const GEMINI_CONFIG = {
    // ⚠️ SECURITY WARNING: Never expose API keys in production!
    // Use a backend proxy instead.
    apiKey: 'AIzaSyBlpo0hUSD2UO8XDt0_4eoUG1e-MDVKYds', 
    apiUrl: 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent',
    
    // 🔥 ENHANCED SYSTEM PROMPT WITH EMERGENCY DETECTION
    systemPrompt: `You are HealthSys IA, a healthcare assistant.

⚠️ CRITICAL SAFETY RULES:
1. If user mentions ANY of these: "heart attack", "chest pain", "can't breathe", "stroke", "severe bleeding", "unconscious", "suicide", "overdose" → IMMEDIATELY respond: "🚨 This is a medical emergency! Call emergency services (911/112/999) NOW or go to the nearest emergency room. Do not wait."
2. NEVER give casual advice for emergency symptoms
3. Always remind users you are NOT a doctor
4. For non-emergencies, provide helpful information but recommend seeing a doctor

For normal questions:
- Be friendly and empathetic
- Keep responses concise (2-3 sentences)
- Use emojis sparingly (1-2 max)
- Always recommend professional medical consultation for persistent symptoms`
  };

  // ===== SCROLL VISIBILITY HANDLER =====
  const chatbotEl = document.querySelector('.ask-ai');
  
  if (chatbotEl) {
    const handleScrollVisibility = () => {
      if (chatbotEl.classList.contains('open') || chatbotEl.classList.contains('half-closed')) return;
      if (window.scrollY > 100) {
        chatbotEl.classList.add('active');
      } else {
        chatbotEl.classList.remove('active');
      }
    };
    window.addEventListener('load', handleScrollVisibility);
    document.addEventListener('scroll', handleScrollVisibility, { passive: true });
  }

  // ===== CHATBOT ELEMENTS =====
  const els = {
    chatbot: chatbotEl,
    conversation: document.getElementById('conversationContainer'),
    userInput: document.getElementById('userInput'),
    sendBtn: document.getElementById('sendBtn'),
    closeBtn: document.getElementById('closeBtn'),
    halfCloseBtn: document.getElementById('halfCloseBtn'),
    typing: document.getElementById('typing'),
    botImage: document.getElementById('botImage'),
    bannerCharacter: document.getElementById('bannerCharacter')
  };

  if (!els.userInput) return;

  // ===== EMERGENCY KEYWORDS DETECTION =====
  const EMERGENCY_KEYWORDS = [
    'heart attack', 'chest pain', 'can\'t breathe', 'cannot breathe', 'difficulty breathing',
    'stroke', 'severe bleeding', 'unconscious', 'suicide', 'overdose', 'poison',
    'severe allergic reaction', 'anaphylaxis', 'seizure', 'convulsion',
    'broken bone', 'fracture', 'major trauma', 'car accident', 'fall from height',
    'pregnancy emergency', 'miscarriage', 'labor', 'contractions',
    'high fever infant', 'baby fever', 'child seizure'
  ];

  // ===== LOCAL FALLBACK RESPONSES =====
  const localResponses = {
    "hello": "Hello! 👋 How can I assist you today?",
    "hi": "Hi there! 😊 What's on your mind?",
    "headache": "For a mild headache: rest, hydrate, and consider OTC pain relief. If it persists, consult a doctor. 🩺",
    "cold": "Stay hydrated, rest, and try OTC meds for symptoms. See a doctor if it worsens. 🤧",
    "heart attack": "🚨 CHEST PAIN IS AN EMERGENCY! Call emergency services (911/112) IMMEDIATELY. Do not drive yourself. Chew aspirin if available while waiting for help.",
    "fever": "Rest, drink fluids, and monitor temperature. Seek help if fever > 39°C or lasts > 3 days.",
    "thank": "You're welcome! 😊 Let me know if you need anything else.",
    "bye": "Take care! 👋 Feel free to come back anytime.",
    "help": "I can help with: general health tips, symptom info, and wellness advice. Just ask!",
    "default": "I'm here to help with health questions. What would you like to know?"
  };

  // ===== ADD MESSAGE TO UI =====
  function addMessage(text, sender) {
    const msgDiv = document.createElement('div');
    msgDiv.className = `message ${sender === 'user' ? 'right' : 'left'}`;
    
    const bubble = document.createElement('div');
    bubble.className = sender === 'user' ? 'user-message' : 'ai-message';
    
    const content = document.createElement('div');
    content.innerHTML = text.replace(/\n/g, '<br>');
    
    const time = document.createElement('small');
    time.className = 'timestamp';
    time.textContent = new Date().toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
    
    bubble.appendChild(content);
    bubble.appendChild(time);
    msgDiv.appendChild(bubble);
    els.conversation.appendChild(msgDiv);
    els.conversation.scrollTop = els.conversation.scrollHeight;
  }

  // ===== CHECK FOR EMERGENCY (CRITICAL!) =====
  function checkEmergency(text) {
    const lower = text.toLowerCase();
    
    // Check for emergency keywords
    for (const keyword of EMERGENCY_KEYWORDS) {
      if (lower.includes(keyword)) {
        return {
          isEmergency: true,
          response: "🚨 **This sounds like a medical emergency!**\n\n**Call emergency services (911/112/999) IMMEDIATELY!**\n\nDo not wait. Do not drive yourself. Get help now.\n\nI am an AI assistant and cannot provide emergency care."
        };
      }
    }
    
    // Check for urgency indicators
    if (lower.match(/\b(urgent|emergency|critical|severe|immediately|right now|dying)\b/)) {
      return {
        isEmergency: true,
        response: "⚠️ **This requires immediate medical attention!**\n\nPlease call emergency services or go to the nearest emergency room now.\n\nYour health and safety are the top priority."
      };
    }
    
    return { isEmergency: false };
  }

  // ===== LOCAL FALLBACK FUNCTION =====
  function getLocalResponse(input) {
    const lower = input.toLowerCase().trim();
    
    // Check emergency FIRST
    const emergency = checkEmergency(input);
    if (emergency.isEmergency) return emergency.response;
    
    // Check predefined responses
    for (const [key, value] of Object.entries(localResponses)) {
      if (lower.includes(key)) return value;
    }
    
    // General symptom matching
    if (lower.match(/\b(pain|ache|hurt|symptom)\b/)) 
      return "I understand you're experiencing discomfort. Rest and hydration help. If symptoms persist or worsen, please consult a healthcare professional. 🩺";
    
    return localResponses.default;
  }

  // ===== GEMINI API CALL =====
  async function callGeminiAPI(userMessage, conversationHistory = []) {
    // 🔥 CHECK FOR EMERGENCY BEFORE CALLING API
    const emergency = checkEmergency(userMessage);
    if (emergency.isEmergency) {
      return emergency.response;
    }

    try {
      const contents = [
        { role: 'user', parts: [{ text: GEMINI_CONFIG.systemPrompt }] },
        ...conversationHistory.slice(-10).map(msg => ({
          role: msg.sender === 'user' ? 'user' : 'model',
          parts: [{ text: msg.text }]
        })),
        { role: 'user', parts: [{ text: userMessage }] }
      ];

      const response = await fetch(
        `${GEMINI_CONFIG.apiUrl}?key=${GEMINI_CONFIG.apiKey}`,
        {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ contents })
        }
      );

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.error?.message || `API Error: ${response.status}`);
      }

      const data = await response.json();
      return data.candidates?.[0]?.content?.parts?.[0]?.text || "I'm sorry, I couldn't process that.";
      
    } catch (error) {
      console.error('Gemini API Error:', error);
      return getLocalResponse(userMessage); // Fallback
    }
  }

  // ===== HANDLE SEND MESSAGE =====
  async function handleSend() {
    const text = els.userInput.value.trim();
    if (!text) return;

    if (!els.chatbot.classList.contains('open')) {
      els.chatbot.classList.add('open', 'active');
    }

    addMessage(text, 'user');
    els.userInput.value = '';
    els.sendBtn.style.display = 'none';
    els.halfCloseBtn.style.display = 'block';

    els.typing?.classList.remove('hide');
    if (els.bannerCharacter) els.bannerCharacter.classList.add('typing');
    els.conversation.scrollTop = els.conversation.scrollHeight;

    try {
      // Get conversation history
      const history = Array.from(els.conversation.querySelectorAll('.message')).slice(-10).map(msg => ({
        sender: msg.classList.contains('right') ? 'user' : 'ai',
        text: msg.querySelector('.ai-message, .user-message')?.innerText || ''
      }));

      const aiResponse = await callGeminiAPI(text, history);
      const formattedResponse = aiResponse.replace(/\n/g, '<br>');
      addMessage(formattedResponse, 'ai');
      
    } catch (error) {
      console.error('Error:', error);
      addMessage("⚠️ Sorry, I'm having trouble connecting. Please try again.", 'ai');
    } finally {
      els.typing?.classList.add('hide');
      if (els.bannerCharacter) els.bannerCharacter.classList.remove('typing');
    }
  }

  // ===== ICON SWAP ON TYPING =====
  els.userInput.addEventListener('input', function() {
    if (this.value.trim() !== "") {
      els.sendBtn.style.display = 'block';
      els.halfCloseBtn.style.display = 'none';
    } else {
      els.sendBtn.style.display = 'none';
      els.halfCloseBtn.style.display = 'block';
    }
  });

  // ===== EVENT LISTENERS =====
  els.sendBtn?.addEventListener('click', handleSend);
  els.userInput?.addEventListener('keypress', e => { if (e.key === 'Enter') handleSend(); });
  
  els.closeBtn?.addEventListener('click', () => {
    els.chatbot.classList.remove('open', 'active');
    if (window.scrollY <= 100) els.chatbot.classList.remove('active');
  });

  els.halfCloseBtn?.addEventListener('click', () => {
    els.chatbot.classList.toggle('half-closed');
  });
});