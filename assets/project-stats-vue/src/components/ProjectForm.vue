<template>
    <form @submit.prevent="onSubmit">
        <span class="help is-danger" v-text="errors"></span>

        <div class="form-group">
                <input class="form-control" type="text" placeholder="Enter Project Name" v-model="project.name"
                       @keydown="errors = ''">

                <input class="form-control" type="text" placeholder="Enter Directory" v-model="project.directory"
                       @keydown="errors = ''">
        </div>

        <button class="btn btn-success" v-bind:class="{ 'is-loading' : isLoading }">Add Project</button>
    </form>
</template>

<script>
    import axios from 'axios'
    import consts from '../consts.js'

    export default {
        data() {
            return {
                title: '',
                errors: '',
                isLoading: false,
                project: {name: "", directory: ""}
            }
        },
        methods: {
            onSubmit() {
                this.isLoading = true
                this.postProject()
            },
            async postProject() {
                axios.post(consts.SERVER + "project/add", {
                        name: this.project.name,
                        directory: this.project.directory
                    }
                ).then(response => {
                    this.title = ''
                    this.isLoading = false
                    this.$emit('completed', response.data)
                }).catch(e => {
                    this.errors = e.toString()
                })
            }
        }
    }
</script>
