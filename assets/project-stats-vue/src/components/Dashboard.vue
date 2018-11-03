<template>
    <section class="section">
        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Project Stats</a>

                <div class="collapse navbar-collapse" id="">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <router-link to="/" tag="button" id='home-button' class="nav-link btn btn-default"> Home
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/project/list" tag="button" id='projects-button'
                                         class="nav-link btn btn-default"> Projects
                            </router-link>
                        </li>
                    </ul>
                </div>

            </nav>

            <router-view></router-view>
        </div>
    </section>
</template>

<script>
    export default {
        data: function () {
            return {
                authenticated: false
            }
        },
        methods: {}
    }
</script>