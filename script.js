/* const btnTop = document.getElementById('btn-top');
window.addEventListener('scroll', function() {
    if (window.pageYOffset >= 600) {
        btnTop.style.display = 'block';
    } else {
        btnTop.style.display = 'none';
    }
}) */

const form = document.getElementById('form');
form.addEventListener('submit', formSend);

async function formSend(e) {
    e.preventDefault();
    let error = formValidate(form);
    let formData = new FormData(form);
    if (error === 0) {
        form.classList.add('sending');
        let response = await fetch('advokat_zhilyaev2/mail.php', {
            method: 'POST',
            body: formData
        });
        if (response.ok) {
            let result = await response.json();
            alert(result.message);
            form.reset();
            form.classList.remove('sending');

        } else {
            alert('Ошибка!');
            form.classList.remove('sending');
        }
    } else {
        alert('Заполните обязательные поля!')
    }
}

function formValidate(form) {
    let error = 0;
    let formReq = document.querySelectorAll('.req')

    for (let index = 0; index < formReq.length; index++) {
        const input = formReq[index];
        formRemoveError(input);

        if (input.classList.contains('email')) {
            if (emailTest(input)) {
                formAddError(input);
                error++;
            }
        } else if (input.getAttribute('type') === "checkbox" && input.checked === false) {
            formAddError(input);
            error++;
        } else {
            if (input.value === "") {
                formAddError(input);
                error++;
            }
        }
    }
    return error;
}

function formAddError(input) {
    input.parentElement.classList.add('error');
    input.classList.add('error');
}

function formRemoveError(input) {
    input.parentElement.classList.remove('error');
    input.classList.remove('error');
}

function emailTest(input) {
    return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
}
