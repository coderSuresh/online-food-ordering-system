// prevent redirect to view page when click on options container
const tableActionContainer = document.querySelectorAll('.table_action_container');
tableActionContainer.forEach(container => {
    container.addEventListener('click', (e) => {
        e.stopPropagation();
    })
})

// prevent redirect to view page when click on action menu
const tableOptionMenu = document.querySelectorAll('.table_option-menu');
tableOptionMenu.forEach(menu => {
    menu.addEventListener('click', (e) => {
        e.stopPropagation();
    })
})