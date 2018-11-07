<template>
    <div class="container">
        <h4>Add a New Project</h4>
        <project-form @completed="addProject"></project-form>

        <h4>Projects list</h4>
        <span class="help is-info" v-if="isLoading">Loading...</span>
        <table class="table" v-else>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Directory</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="(project, index) in projects">
                <tr v-bind:key="project.id">
                    <td>{{ project.id }}</td>
                    <td>{{ project.name }}</td>
                    <td>{{ project.directory }}</td>
                    <td>{{ project.created_at }}</td>
                    <td>
                        <router-link :to="{ name: 'statistics', params: { id: project.id }}" class="btn btn-success">
                            Show
                        </router-link>
                        <button type="button" class="btn btn-primary" @click="openModal(project.id)">
                            Edit
                        </button>
                        <button class="btn btn-danger" @click="removeProject(project.id, index)">
                            Remove
                        </button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>

        <edit-project-modal :project="project" @projectUpdateCompleted="updateProject"></edit-project-modal>
    </div>

</template>

<script>
    import axios from 'axios'
    import ProjectForm from './ProjectForm.vue'
    import EditProjectModal from './Modals/EditProjectModal'
    import consts from '../consts.js'

    export default {
        components: {
            ProjectForm,
            EditProjectModal
        },
        data() {
            return {
                projects: {},
                isLoading: true,
                countUpdatingTable: [],
                project: {id: ""}
            }
        },
        async created() {
            try {
                const response = await axios.get(consts.SERVER + "project/list")
                this.projects = response.data
                this.isLoading = false
            } catch (e) {
                this.errors = e.toString()
            }
        },
        methods: {
            addProject(project) {
                this.projects.push(project.object)
            },
            updateProject(project) {
                let projectid = project.object.id

                this.projects.find(e => {
                    if (e.id === projectid) {
                        e.name = project.object.name
                        e.directory = project.object.directory
                    }
                });

                $("#editProjectModal").modal("hide")
            },
            async removeProject(id, index) {
                axios.delete(consts.SERVER + "project/" + id + "/remove",
                ).then(response => {
                    this.isLoading = false
                    this.projects.splice(index, 1)
                }).catch(e => {
                    this.errors = e.toString()
                })
            },
            openModal(projectid) {
                axios.get(consts.SERVER + "project/" + projectid + "/show"
                ).then(response => {

                    this.isLoading = false
                    this.project.id = response.data.id
                    this.project.name = response.data.name
                    this.project.directory = response.data.directory

                    $("#editProjectModal").modal("show")
                }).catch(e => {
                    this.errors = e.toString()
                })
            }
        }
    }
</script>
