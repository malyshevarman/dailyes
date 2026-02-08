<template>
    <div>
        <a @click.prevent="deleteuser()" href="/cabinet/delete" style="color:red;"><img src="/images/icons/lk/delete.svg"/> Удалить профиль</a>
    </div>
</template>

<script>
    export default {
        name: "deleteprofile",
        methods:{
            deleteuser(){
                swal({
                    title: "Вы уверены?",
                    text: "Это необратимый процесс!",
                    icon: "warning",
                    buttons: ["Нет", "Да"],
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            location.href = `/cabinet/delete`
                        } else {

                        }
                    })

            }
        }
    }
</script>
