document.addEventListener('DOMContentLoaded', function () {

    const destroyForms = document.querySelectorAll('.destroy-logo');
    destroyForms.forEach(function (destroyForm) {
        destroyForm.addEventListener('submit', function (e) {
            e.preventDefault();
            console.log('fsd');
            console.log(this);

            const $this = this;

            swal({
                content: 3,
                title: "Usunąć?",
                text: "Elementu nie będzie się dało odzyskać!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Usuń",
                cancelButtonText: "Nie usuwaj",
                closeOnConfirm: true,
                closeOnCancel: true,
            },
            function (isConfirm) {
                if (!isConfirm) {
                    return;
                }

                console.log($this);
                $this.submit();

                // const formLogoDestroy = document.querySelector('#destroy-logo-' + logoId);
                // console.log(formLogoDestroy);

                // formLogoDestroy.submit();
            });

        });
    });

}, false);

$('.delete-warning').click(function () {

    const logoId = this.getAttribute('data-logo-id');


});
