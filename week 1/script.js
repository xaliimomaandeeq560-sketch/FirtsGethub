// Form validation
document.getElementById("contactForm").addEventListener("submit", function(e) {
  e.preventDefault();
  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const message = document.getElementById("message").value.trim();

  if (!name || !email || !message) {
    alert("Please fill all fields!");
  } else {
    alert("Thank you for contacting us, " + name + "!");
    this.reset();
  }
});

// Back to top button
const topBtn = document.getElementById("backToTop");
topBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
