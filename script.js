const forms = document.querySelectorAll('form'),
    short_button = document.querySelector('#short_button'),
    long_url = document.querySelector('#long_url'),
    short_url_tag = document.querySelector('#short_url_tag'),
    login_button = document.querySelector('#login_button'),
    logout_button = document.querySelector('#log-out'),
    login_username = document.querySelector('#login_username'),
    login_password = document.querySelector('#login_password'),
    overlay = document.querySelector("#overlay"),
    customConfirm = document.querySelector("#custom-confirm"),
    confirmYesButton = document.querySelector("#confirm-yes"),
    confirmNoButton = document.querySelector("#confirm-no"),
    save_new_user = document.querySelector("#save_new_user"),
    new_user_name = document.querySelector("#new_user_name"),
    new_user_password = document.querySelector("#new_user_password"),
    new_user_isAdmin = document.querySelector("#new_user_isAdmin");

const service = 'service/_service.php'
const isValidUrl = (url) => /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/.test(url);

forms.forEach((form) => {
    form.onsubmit = (e) => e.preventDefault();
})

if (login_button)
    login_button.onclick = () => {
        buttonDisabledTime(login_button, 2)
        const username = login_username.value;
        const password = login_password.value;
        fetch(service, {
            method: 'POST',
            body: new URLSearchParams({ username: username, password: password, type: "login" })
        }).then(response => {
            if (!response.ok) throw new Error("Network response was not ok");
            return response.json();
        }).then(async (result) => {
            await createAlert(result["message"], result["type"], 4);
            if (result["type"] == "success") {
                location.reload();
            }
        })
    };

if (logout_button)
    logout_button.onclick = async () => {
        const userConfirmed = await myConfirm("Çıkış yapmak istediğinize emin misiniz ?")
        if (userConfirmed) {
            fetch(service, {
                method: 'POST',
                body: new URLSearchParams({ type: "logout" })
            }).then(response => {
                if (!response.ok) throw new Error("Network response was not ok");
                return response.json();
            }).then(async (result) => {
                await createAlert(result["message"], result["type"], 4);
                if (result["type"] == "success") location.reload();
            })
        }
    };


if (short_button)
    short_button.onclick = () => {
        buttonDisabledTime(short_button, 4)
        const url = long_url.value;
        if (isValidUrl(url)) {
            const short_tag = short_url_tag.value || null;
            fetch(service, {
                method: 'POST',
                body: new URLSearchParams({ full_url: url, short_tag: short_tag, type: "add_new_url" })
            }).then(response => {
                if (!response.ok) throw new Error("Network response was not ok");
                return response.text();
            }).then(async (result) => {
                await createAlert(result["message"], result["type"], 4);
                if (result["type"] == "success") location.reload();
            })
        } else {
            createAlert("Geçerli bir url adresi girin", "error", 3)
        }
    }


if (save_new_user)
    save_new_user.onclick = async () => {
        buttonDisabledTime(save_new_user, 2)
        const userName = new_user_name.vale;
        const password = new_user_password.value;
        const isAdmin = new_user_isAdmin.checked;
        if (!userName || !password) {
            createAlert("Kullanıcı adı ve Şifre boş olamaz", "error", 2)
        } else {
            const userConfirmed = await myConfirm(`kullanıcı adı : ${userName} /  şifre : ${password} / admin : ${isAdmin} bilgileri ile yeni üye eklemek istediğinize emin misiniz ?`)
            if (userConfirmed) {
                fetch(service, {
                    method: 'POST',
                    body: new URLSearchParams({ type: 'add_new_user', username: userName, password: password, isAdmin: isAdmin })
                }).then((response) => {
                    if (!response.ok) throw new Error("Network response was not ok");
                    return response.json()
                }).then(async (result) => {
                    await createAlert(result["message"], result["type"], 4);
                    if (result["type"] == "success") location.reload();
                })
            }
        }
    }


const createAlert = async (text, type, time) => {
    const alertDiv = document.querySelector(".alert-box");
    if (alertDiv.firstChild) {
        await animateCSS(alertDiv.firstChild, 'fadeInLeft');
        removeAlert(alertDiv.firstChild)
    }
    let alertİcon = ""
    switch (type) {
        case "info":
            alertİcon = "fa-solid fa-bell";
            break;
        case "error":
            alertİcon = "fa-solid fa-circle-exclamation";
            break;
        case "success":
            alertİcon = "fa-solid fa-circle-check";
            break;
        default:
            break;
    }
    alertDiv.innerHTML = `<div class="alert ${type}">
    <i class="${alertİcon}"></i> <p> ${text} </p>
    <span class="closebtn" onclick="removeAlert(this.parentElement)">&times;</span>
    </div>`
    await animateCSS(alertDiv.firstChild, 'fadeInLeft');
    alertTimeOut = setTimeout(async () => {
        removeAlert(alertDiv.firstChild)
    }, time * 1000);
}

const removeAlert = async (alert) => {
    await animateCSS(alert, 'fadeOutLeft');
    alert.remove();
    clearTimeout(alert);
}

const animateCSS = (element, animation, prefix = 'animate__') =>
    new Promise((resolve, reject) => {
        const animationName = prefix + animation;
        element.classList?.add(prefix + 'animated', animationName);
        function handleAnimationEnd(event) {
            event.stopPropagation();
            element.classList?.remove(prefix + 'animated', animationName);
            resolve('Animation ended');
        }
        element.addEventListener('animationend', handleAnimationEnd, { once: true });
    });


const buttonDisabledTime = async (button, time) => {
    button.disabled = true;
    setTimeout(() => {
        button.disabled = false;
    }, time * 1000);
}

const myConfirm = (text = "Yapmak istediniz işlemi onaylıyor musunuz ?") =>
    new Promise((resolve, reject) => {
        overlay.style.display = "block";
        customConfirm.style.display = "block";
        customConfirm.querySelector("p").textContent = text;
        confirmYesButton.addEventListener("click", () => {
            overlay.style.display = "none";
            customConfirm.style.display = "none";
            resolve(true);
        });

        confirmNoButton.addEventListener("click", () => {
            overlay.style.display = "none";
            customConfirm.style.display = "none";
            resolve(false);
        });
    });
