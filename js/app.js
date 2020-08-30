const tabs = document.querySelectorAll("[data-tab-target]");
const tabContents = document.querySelectorAll("[data-tab-content]");
const navToogle = document.querySelector(".nav-toggle");

const navLinks = document.querySelectorAll(".nav__link");

tabs.forEach(tab => {
  tab.addEventListener("click", () => {
    const target = document.querySelector(tab.dataset.tabTarget);
    tabContents.forEach(content => {
      content.classList.remove("active");
    });
    tabs.forEach(tab => {
      tab.classList.remove("active");
    });
    tab.classList.add("active");
    target.classList.add("active");
  });
});

navToogle.addEventListener("click", () => {
  document.body.classList.toggle("nav-open");
});

navLinks.forEach(link => {
  link.addEventListener("click", () => {
    document.body.classList.remove("nav-open");
  });
});

// contact Message Code
let addMessageContainer = document.getElementById("addMessage");

let successMessage = data => {
  addMessageContainer.innerHTML = "";
  let messageDiv = document.createElement("div");
  messageDiv.className = "success-message";
  messageDiv.innerText = data;
  addMessageContainer.appendChild(messageDiv);
  document.getElementById("name").value = "";
  document.getElementById("email").value = "";
  document.getElementById("messageText").value = "";
  disappearMessage();
};

let showErrorMessage = data => {
  console.log(data);
  data.forEach((error, index) => {
    console.log(index);
    let messageDiv = document.createElement("div");
    messageDiv.className = "error-message";
    messageDiv.innerText = error;
    addMessageContainer.appendChild(messageDiv);
  });
};

let disappearMessage = () => {
  setTimeout(() => {
    addMessageContainer.innerHTML = "";
  }, 10000);
};

let sendButton = document.getElementById("sendBtn");
sendButton.addEventListener("click", e => {
  buttonDisable(true);

  let name = document.getElementById("name").value;
  let email = document.getElementById("email").value;
  let messageText = document.getElementById("messageText").value;
  let data = {
    name,
    email,
    messageText,
  };

  axios({
    method: "POST",
    url: "contact.php",
    data: data,
    data,
  })
    .then(response => {
      buttonDisable(false);
      console.log(response);
      if (response.data.errors) {
        showErrorMessage(response.data.errors);
      } else if (response.data.success) {
        successMessage(response.data.success);
      } else {
        let error = ["Internal Server Error"];
        showErrorMessage(error);
      }
    })
    .catch(err => {
      buttonDisable(false);
      console.log(err);
    });
});

let buttonDisable = disble => {
  if (disble) {
    sendButton.disabled = true;
    sendButton.style.backgroundColor = "#1C2833";
    sendButton.style.color = "#fff";
    sendButton.style.cursor = "not-allowed";
    addMessageContainer.innerHTML = "";
    sendButton.innerHTML = `<i class="fas fa-paper-plane"></i> Sending...`;
  } else {
    sendButton.disabled = false;
    sendButton.style.backgroundColor = "transparent";
    sendButton.style.color = "#FF5733";
    sendButton.style.cursor = "pointer";
    sendButton.innerHTML = `<i class="fas fa-paper-plane"></i> Send`;
  }
};
