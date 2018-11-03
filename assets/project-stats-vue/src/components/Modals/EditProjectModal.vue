<template>

    <div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="onSubmit">
                    <div class="modal-body">

                        <span class="help is-danger" v-text="errors"></span>

                        <div class="form-group">
                            <input type="hidden" v-model="project.id">
                            <input class="form-control" type="text" placeholder="Enter Project Name"
                                   v-model="project.name"
                                   @keydown="errors = ''">

                            <input class="form-control" type="text" placeholder="Enter Directory"
                                   v-model="project.directory"
                                   @keydown="errors = ''">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-success" v-bind:class="{ 'is-loading' : isLoading }">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script>
    import axios from 'axios'
    import consts from '../../consts.js'

    export default {
        props:['project'],
        data() {

            return {
                title: '',
                errors: '',
                isLoading: true,

            }
        },
        methods: {
            onSubmit() {
                this.isLoading = true
                this.updateProject()
            },
            async updateProject() {
                axios.put(consts.SERVER + "project/"+this.project.id+"/update", {
                        id: this.id,
                        name: this.project.name,
                        directory: this.project.directory
                    }
                ).then(response => {
                    this.title = ''
                    this.isLoading = false
                    this.$emit('projectUpdateCompleted', response.data)
                }).catch(e => {
                    this.errors = e.toString()
                })
            },
            setData(data) {

                this.project = data
                console.log(this.project)
            }
        }
    }
</script>
