<template>
    <div class="containter">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')

        let channel = Echo.channel('user-channel');
        channel.listen('.UserEvent', (data) => {
            console.log(data);
        });
    }

}
</script>
