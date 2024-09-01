document.addEventListener('DOMContentLoaded', function () {
    var selectCategory = document.getElementById('selectCategory');
    var selectSubCategory = document.getElementById('selectSubCategory');

    selectCategory.addEventListener('change', function () {
        var category = this.value;
        var subcategoryOptions = {
            'polos': ['subcat1', 'subcat2', 'subcat3'],
            'poleras': ['subcat1', 'subcat2', 'subcat3'],
            'chompas': ['subcat1', 'subcat2', 'subcat3'],
            'jeans': ['subcat1', 'subcat2', 'subcat3'],
            'zapatillas': ['subcat1', 'subcat2', 'subcat3']
        };

        selectSubCategory.innerHTML = '<option value="">Seleccionar subcategoría</option>';

        if (subcategoryOptions[category]) {
            subcategoryOptions[category].forEach(function (subcat) {
                var option = document.createElement('option');
                option.value = subcat;
                option.textContent = subcat.charAt(0).toUpperCase() + subcat.slice(1);
                selectSubCategory.appendChild(option);
            });
        }
    });
});
