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
    new_user_isAdmin = document.querySelector("#new_user_isAdmin"),
    edit_url_button = document.querySelectorAll('.edit-url'),
    delete_url_button = document.querySelectorAll('.delete-url'),
    delete_user_button = document.querySelectorAll('.delete-user'),
    edit_user_button = document.querySelectorAll('.edit-user');

const service = 'service/_service.php'

// Yalnızca url içeren regex regex ifadesi
const isValidUrl = (url) => /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/.test(url);
// Yalnızca harf, rakam ve nokta karakterlerini içeren bir regex ifadesi / Türkçe karakterleri destekler
const isValidStringTag = (inputString) => /^[a-zA-Z0-9.ÇçĞğİıÖöŞşÜü]+$/.test(inputString);

window.onload = () => {
    if (forms)
        forms.forEach((form) => {
            form.onsubmit = (e) => e.preventDefault();
        });

    if (login_button)
        login_button.onclick = () => {
            buttonDisabledTime(login_button, 3)
            const username = login_username.value;
            const password = login_password.value;
            fetch(service, {
                method: 'POST',
                body: new URLSearchParams({ username: username, password: password, type: "login" })
            }).then(response => {
                if (!response.ok) throw new Error("Network response was not ok");
                return response.json();
            }).then(async (result) => {
                await createAlert(result["message"], result["type"]);
                if (result["type"] == "success") {
                    location.reload();
                }
            })
        };

    if (logout_button)
        logout_button.onclick = async () => {
            const userConfirmed = await myConfirm("Çıkış yapmak istediğinize emin misiniz ?")
            if (userConfirmed) {
                buttonDisabledTime(logout_button, 3)
                fetch(service, {
                    method: 'POST',
                    body: new URLSearchParams({ type: "logout" })
                }).then(response => {
                    if (!response.ok) throw new Error("Network response was not ok");
                    return response.json();
                }).then(async (result) => {
                    await createAlert(result["message"], result["type"]);
                    if (result["type"] == "success") location.reload();
                })
            }
        };

    if (short_button)
        short_button.onclick = () => {
            buttonDisabledTime(short_button, 3)
            const url = long_url.value.trim();
            if (isValidUrl(url)) {
                const short_tag = short_url_tag.value.trim() || null;
                if (!isValidStringTag(short_tag)) return createAlert("Geçerli bir Takma Ad  girin (sadece Harf , sayı ve nokta kullanabilirsiniz)", "error", 2);
                fetch(service, {
                    method: 'POST',
                    body: new URLSearchParams({ full_url: url, short_tag: short_tag, type: "add_new_url" })
                }).then(response => {
                    if (!response.ok) throw new Error("Network response was not ok");
                    // console.log(response.text());
                    return response.json();
                }).then(async (result) => {
                    await createAlert(result["message"], result["type"], 2);
                    if (result["type"] == "success") location.reload();
                })
            } else {
                createAlert("Geçerli bir url adresi girin", "error", 2)
            }
        };

    if (save_new_user)
        save_new_user.onclick = async () => {
            const userName = new_user_name.value.trim();
            const password = new_user_password.value;
            const isAdmin = new_user_isAdmin.checked;
            if (userName == "" || password == "") {
                buttonDisabledTime(save_new_user, 3)
                createAlert("Kullanıcı adı ve Şifre boş olamaz", "error")
            } else {
                const userConfirmed = await myConfirm(`kullanıcı adı : ${userName}   |  şifre : ${password}  |  admin : ${isAdmin}   ; bilgileri ile yeni üye eklemek istediğinize emin misiniz ?`)
                if (userConfirmed) {
                    buttonDisabledTime(save_new_user, 3)
                    fetch(service, {
                        method: 'POST',
                        body: new URLSearchParams({ type: 'add_new_user', username: userName, password: password, isAdmin: isAdmin })
                    }).then((response) => {
                        if (!response.ok) throw new Error("Network response was not ok");
                        return response.json()
                    }).then(async (result) => {
                        await createAlert(result["message"], result["type"]);
                        if (result["type"] == "success") {
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    })
                }
            }
        };

    if (delete_url_button)
        delete_url_button.forEach(async (deletebtn) => {
            deletebtn.onclick = async () => {
                const url = deletebtn.dataset['tag']
                const userConfirmed = await myConfirm(url + " - linkini silmek istediğinize emin misiniz ?")
                if (userConfirmed) {
                    buttonDisabledTime(deletebtn, 3)
                    fetch(service, {
                        method: 'POST',
                        body: new URLSearchParams({ type: 'delete_url', url: url })
                    }).then((response) => {
                        if (!response.ok) throw new Error("Network response was not ok");
                        // console.log(response.text())
                        return response.json()
                    }).then(async (result) => {
                        await createAlert(result["message"], result["type"]);
                        if (result["type"] == "success") {
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    })
                }
            }
        });

    if (edit_url_button)
        edit_url_button.forEach(async (editbtn) => {
            editbtn.onclick = async () => {
                const url = editbtn.dataset['tag']
                const newUrl = editbtn.parentElement.parentElement.querySelector('input').value.trim();
                if (newUrl == "") return createAlert("Düzenleme için yeni bir takma ad girin ! ", "info");
                if (newUrl == url) return createAlert("Yeni takma ad zaten eskisi ile aynı ! ", "info");
                if (!isValidStringTag(newUrl)) return createAlert("Geçerli bir Takma Ad  girin (sadece Harf , sayı ve nokta kullanabilirsiniz)", "error", 2);
                const userConfirmed = await myConfirm(`'${url}'  tagını   '${newUrl}' ile değiştirmek istediğinize emin misiniz ? `)
                if (userConfirmed) {
                    buttonDisabledTime(editbtn, 3)
                    fetch(service, {
                        method: 'POST',
                        body: new URLSearchParams({ type: "edit_url", url: url, newUrl: newUrl })
                    }).then((response) => {
                        if (!response.ok) throw new Error("Network response was not ok");
                        // console.log(response.text())
                        return response.json()
                    }).then(async (result) => {
                        await createAlert(result["message"], result["type"]);
                        if (result["type"] == "success") {
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    })
                }
            }
        });

    if (delete_user_button)
        delete_user_button.forEach(async (userdlt) => {
            userdlt.onclick = async () => {
                const userName = userdlt.dataset['username'];
                const userConfirmed = await myConfirm(`'${userName}'  Kullanıcısını silmek istediğinize emin misiniz (Oluşturduğu tüm linkler silinecek) ? `)
                if (userConfirmed) {
                    buttonDisabledTime(userdlt, 4)
                    fetch(service, {
                        method: 'POST',
                        body: new URLSearchParams({ type: "delete_user", username: userName })
                    }).then((response) => {
                        if (!response.ok) throw new Error("Network response was not ok");
                        // console.log(response.text())
                        return response.json()
                    }).then(async (result) => {
                        await createAlert(result["message"], result["type"]);
                        if (result["type"] == "success") {
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    })
                }
            }
        });

    if (edit_user_button)
        edit_user_button.forEach(async (editbtn) => {
            editbtn.onclick = async () => {
                // const userName = editbtn.dataset['username'];
                // const userConfirmed = await myConfirm(`'${userName}'  Kullanıcısını silmek istediğinize emin misiniz (Oluşturduğu tüm linkler silinecek) ? `)
                // if (userConfirmed) {
                //     buttonDisabledTime(editbtn, 4)
                //     fetch(service, {
                //         method: 'POST',
                //         body: new URLSearchParams({ type: "delete_user", username: userName })
                //     }).then((response) => {
                //         if (!response.ok) throw new Error("Network response was not ok");
                //         // console.log(response.text())
                //         return response.json()
                //     }).then(async (result) => {
                //         await createAlert(result["message"], result["type"]);
                //         if (result["type"] == "success") {
                //             setTimeout(() => {
                //                 location.reload();
                //             }, 2000);
                //         }
                //     })
                // }
            }
        });
}

const createAlert = async (text, type, time = 1) => {
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
        element?.classList.add(prefix + 'animated', animationName);
        function handleAnimationEnd(event) {
            event.stopPropagation();
            element?.classList.remove(prefix + 'animated', animationName);
            resolve('Animation ended');
        }
        element?.addEventListener('animationend', handleAnimationEnd, { once: true });
    });


const buttonDisabledTime = async (button, time) => {
    button.disabled = true;
    setTimeout(() => {
        button.disabled = false;
    }, time * 1000);
}

const myConfirm = (text = "Yapmak istediniz işlemi onaylıyor musunuz ?", yes = 'Evet', no = 'Hayır') =>
    new Promise((resolve, reject) => {
        overlay.style.display = "block";
        customConfirm.style.display = "block";

        customConfirm.querySelector("p").textContent = text;
        confirmYesButton.textContent = yes;
        confirmNoButton.textContent = no;

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


const executeCopy = async (copyText) => {
    await navigator.clipboard.writeText(copyText)
        .then(function () {
            createAlert("Kopyalandı", "info", 2);
        })
        .catch(function (err) {
            createAlert("Kopyalama başarısız : " + err, "error", 2);
        });
};

