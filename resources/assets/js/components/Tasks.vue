<template>
    <div class="container">
        <div class="row"></div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Todo List</div>
                    <div class="panel-body">
                        <div class="form-group">
                                <input type="text" v-model="newTask" class="form-control" placeholder="新增要做的事項..." @keyup.enter="createTask()" autofocus>
                        </div>
                        <div class="form-group">
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="task in tasks">
                                        <div v-show="task === editTask">
                                            <input type="text" class="form-control"
                                                :value="task.body"
                                                @keyup.enter="updateTask(task)"
                                                @keyup.esc="editTask = ''"
                                                @blur="editTask = ''"
                                                v-task-focus="task === editTask"
                                                v-model="task.body"
                                            >
                                        </div>
                                        <div v-show="task !== editTask" @dblclick="editTask = task">
                                            <input type="checkbox" @click="toggleCheck(task)" :checked="task.checked == 1">
                                            <label :class="{ checked: task.checked == 1 }">{{ task.body }}</label>
                                            <button class="btn btn-default btn-xs pull-right"
                                                @click="deleteTask(task)"
                                            >x</button>
                                        </div>
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
                newTask: '',
                tasks: [],
                editTask: ''
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
                this.$http.post('api/task/store', { body: this.newTask });
                this.newTask = '';
                this.getAllTasks();
            },

            updateTask: function (task) {
                this.$http.patch('api/task/' + task.id, { body: task.body });
                this.editTask = '';
                this.getAllTasks();
            },

            deleteTask: function (task) {
                this.$http.delete('api/task/' + task.id);
                this.getAllTasks();
            },

            toggleCheck: function (task) {
                task.checked = (task.checked == 0) ? 1 : 0;
                this.$http.patch('api/task/' + task.id, { checked: task.checked });
            }
        },

        directives: {
            'task-focus': function (el, value) {
                if (value) {
                    el.focus();
                }
            }
        }
    }
</script>