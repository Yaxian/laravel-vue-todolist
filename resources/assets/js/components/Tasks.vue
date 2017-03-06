<template>
    <div class="container">
        <div class="row"></div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Todo List</div>
                    <div class="panel-body">
                        <div class="form-group">
                                <input type="text" v-model="task.body" name="body" class="form-control" placeholder="新增要做的事項..." @keyup.enter="createTask()" autofocus>
                        </div>
                        <div class="form-group">
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="task in tasks">
                                        {{ task.body }}
                                        <button class="btn btn-default btn-xs pull-right" @click="deleteTask(task.id)">x</button>
                                    </li>
                                </ul>
                        </div>
                        <!-- {{ JSON.stringify($data) }} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                tasks: [
                    //{'body': '1'},
                    //{'body': '2'},
                ],
                task: {
                    id: '',
                    body: ''
                }
            }
        },

        mounted: function () {
            this.getAllTasks();
        },

        methods: {
            getAllTasks: function () {
                this.$http.get('api/tasks').then(function (response) {
                    this.tasks = response.data;
                });
            },

            createTask: function () {
                this.$http.post('api/task/store', this.task);
                this.task.body = '';
                this.getAllTasks();
            },

            deleteTask: function (id) {
                this.$http.delete('api/task/' + id);
                this.getAllTasks();
            }
        }
    }
</script>