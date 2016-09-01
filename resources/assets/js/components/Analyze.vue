<template>
    <div class="panel panel-default">
        <div class="panel-heading">Example Component</div>

        <div class="panel-body">
            Message : {{message}}
        </div>
    </div>
</template>

<script>
    export default {
        ready() {
            console.log('Component ready.')
        }
    }
</script>
