jQuery(document).ready(function($) {

    $(".ims-add-field").click(function() {
        let fieldType = $(this).data("type");
        let fieldId = "field_" + Math.floor(Math.random() * 10000); // unical id

        let fieldHtml = `
        <div class="ims-field" data-id="${fieldId}">
            <select class="ims-field-type">
                <option value="text" ${fieldType === 'text' ? 'selected' : ''}>Text</option>
                <option value="numeric" ${fieldType === 'numeric' ? 'selected' : ''}>Numeric</option>
                <option value="telephone" ${fieldType === 'telephone' ? 'selected' : ''}>Telephone</option>
                <option value="email" ${fieldType === 'email' ? 'selected' : ''}>E-mail</option>
            </select>
            <input type="text" class="ims-field-id" placeholder="ID" />
            <input type="text" class="ims-field-name" placeholder="Name" />
            <input type="text" class="ims-field-placeholder" placeholder="Placeholder" />
            <input type="text" class="ims-field-class" placeholder="CSS class" />
            <button class="ims-remove-field">X</button>
        </div>
    `;

        // add new field to form
        $("#ims-fields-container").append(fieldHtml);
    });

// handle field remove. Fields can be added dynamicly
    $(document).on("click", ".ims-remove-field", function() {
        $(this).closest(".ims-field").remove(); // remove the nearest field
    });


// handle ajax form save
    $("#ims-save-form").click(function(e) {
        e.preventDefault();

        let formName = prompt("Enter form name:");
        if (!formName) return;

        let fields = [];
        $("#ims-fields-container .ims-field").each(function() {
            let field = {
                type: $(this).find(".ims-field-type").val(),
                id: $(this).find(".ims-field-id").val(),
                name: $(this).find(".ims-field-name").val(),
                placeholder: $(this).find(".ims-field-placeholder").val(),
                class: $(this).find(".ims-field-class").val()
            };
            fields.push(field);
        });

        let formData = {
            form_name: formName,
            form_fields: fields
        };

        $.ajax({
            type: 'POST',
            url: ims_contact_forms_ajax.ajax_url,
            data: {
                action: 'ims_save_contact_form',
                formData: JSON.stringify(formData),
                nonce: ims_contact_forms_ajax.nonce
            },
            success: function (response) {
                console.log(response);
                showAlert("Formularz został zapisany!", "success");
            },
            error: function (response) {
                showAlert("Błąd podczas zapisu!<br />" + response, "error");
            }
        });

    });
});

function showAlert(message, type = "success") {
    const alertArea = document.getElementById("ims-alert-area");
    if (!alertArea) return;

    alertArea.innerHTML = `<div class="ims-alert ims-alert-${type}">${message}</div>`;
    const alertBox = alertArea.querySelector(".ims-alert");
    alertBox.style.display = "block";

    setTimeout(() => {
        alertBox.style.display = "none";
    }, 5000); // disappear after five seconds
}
