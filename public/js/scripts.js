// Handle form field changes based on selected product type
document.addEventListener('DOMContentLoaded', handleTypeChange);

function handleTypeChange() {
    const type = document.getElementById('type').value;
    const typeSpecificFields = document.getElementById('type_specific_fields');
    const dynamicDescription = document.getElementById('dynamic-description');
    
    // Clear previous fields and descriptions
    typeSpecificFields.innerHTML = '';
    dynamicDescription.innerHTML = '';

    // Update fields and description based on selected type
    switch (type) {
        case 'DVD':
            typeSpecificFields.innerHTML = `
                <label for="size">Size (MB):</label>
                <input type="number" id="size" name="size" step="0.01" required><br>
            `;
            dynamicDescription.innerHTML = '<p>Please, provide size.</p>';
            break;
        case 'Book':
            typeSpecificFields.innerHTML = `
                <label for="weight">Weight (KG):</label>
                <input type="number" id="weight" name="weight" step="0.01" required><br>
            `;
            dynamicDescription.innerHTML = '<p>Please, provide weight.</p>';
            break;
        case 'Furniture':
            typeSpecificFields.innerHTML = `
                <label for="height">Height (CM):</label>
                <input type="number" id="height" name="height" step="0.01" required><br>
                <label for="width">Width (CM):</label>
                <input type="number" id="width" name="width" step="0.01" required><br>
                <label for="length">Length (CM):</label>
                <input type="number" id="length" name="length" step="0.01" required><br>
            `;
            dynamicDescription.innerHTML = '<p>Please, provide dimensions.</p>';
            break;
    }
}

// Validate form inputs and display error messages
function validateForm() {
    const sku = document.getElementById('sku').value;
    const name = document.getElementById('name').value;
    const price = document.getElementById('price').value;
    const type = document.getElementById('type').value;
    const errors = {};

    // SKU validation
    if (sku.trim() === '') {
        errors['sku'] = 'Please, submit required data';
    }

    // Name validation
    if (name.trim() === '') {
        errors['name'] = 'Please, submit required data.';
    } else if (!/^[a-zA-Z\s]+$/.test(name)) {
        errors['name'] = 'Please, provide the data of indicated type for Name.';
    }

    // Price validation
    if (price.trim() === '') {
        errors['price'] = 'Please, submit required data.';
    } else if (isNaN(price) || price <= 0) {
        errors['price'] = 'Please, provide the data of indicated type for Price.';
    }

    // Type validation
    if (type === '') {
        errors['type'] = 'Please, submit required data.';
    }

    // Clear previous error messages
    clearErrors();

    // Display new error messages
    displayErrors(errors);

    // Return false if there are errors
    return Object.keys(errors).length === 0;
}

// Clear previous error messages
function clearErrors() {
    document.getElementById('sku-error').innerHTML = '';
    document.getElementById('name-error').innerHTML = '';
    document.getElementById('price-error').innerHTML = '';
    document.getElementById('type-error').innerHTML = '';
}

// Display error messages
function displayErrors(errors) {
    if (errors['sku']) {
        document.getElementById('sku-error').innerHTML = errors['sku'];
    }
    if (errors['name']) {
        document.getElementById('name-error').innerHTML = errors['name'];
    }
    if (errors['price']) {
        document.getElementById('price-error').innerHTML = errors['price'];
    }
    if (errors['type']) {
        document.getElementById('type-error').innerHTML = errors['type'];
    }
}

// Handle mass deletion of products
function massDelete() {
    const checkboxes = document.querySelectorAll('.delete-checkbox');
    const checkedBoxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);
    const errorMessage = document.querySelector('.error-message');
    const successMessage = document.getElementById('success-message');

    if (checkedBoxes.length > 0) {
        errorMessage.style.display = 'none';
        document.getElementById('product_list').submit();
        // Display success message
        successMessage.style.display = 'block';
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 2000); // Hide after 2 seconds
    } else {
        errorMessage.textContent = 'You should select a product to delete.';
        errorMessage.style.display = 'block';
    }
}
