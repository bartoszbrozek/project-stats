<template>
    <div class="container">
        <h4>Project Statistics</h4>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Directory</th>
                <th>Filename</th>
                <th>Size</th>
                <th>Lines</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="stat in dirStats">
                <tr v-bind:key="stat.id">
                    <td>{{ stat.id }}</td>
                    <td>{{ stat.relativeDirectory }}</td>
                    <td>{{ stat.filename }}</td>
                    <td>{{ stat.filesize }}</td>
                    <td>{{ stat.numberOfLines }}</td>
                    <td>{{ stat.created_at.date }}</td>
                </tr>
            </template>
            </tbody>
        </table>

    </div>

</template>
<script>
    import axios from 'axios'
    import consts from '../consts.js'

    export default {
        props: ['id'],
        data: function () {
            return {
                dirStats: {}
            }
        },
        async created() {
            axios.get(consts.SERVER + "dirstats/" + this.id + "/show",
            ).then(response => {
                console.log(response)
                this.dirStats = response.data
            }).catch(e => {
                console.log(e.toString())
            })
        },
        methods: {}
    }
</script>
