/**
 * SecuLab CTF - JavaScript
 */

document.addEventListener("DOMContentLoaded", () => {
  console.log("🔐 SecuLab CTF loaded");

  // Auto-scroll chat to bottom
  const chatMessages = document.getElementById("chatMessages");
  if (chatMessages) {
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  // Add subtle animations to module cards
  const moduleCards = document.querySelectorAll(".module-preview");
  moduleCards.forEach((card, index) => {
    card.style.animationDelay = `${index * 0.1}s`;
    card.classList.add("fade-in");
  });
});

// Easter egg: Konami code reveals a message
let konamiCode = [];
const konamiSequence = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65];

document.addEventListener("keydown", (e) => {
  konamiCode.push(e.keyCode);
  if (konamiCode.length > 10) konamiCode.shift();

  if (konamiCode.join(",") === konamiSequence.join(",")) {
    alert(
      "🎮 Konami Code activé ! Tu as le sens du détail... Continue à chercher les failles !",
    );
    konamiCode = [];
  }
});
