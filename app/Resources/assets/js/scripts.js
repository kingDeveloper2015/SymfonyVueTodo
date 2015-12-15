new Vue({
    el: '#app',

    ready: function() {

        // GET request
        this.$http.get('/api/todos', function (data, status, request) {

            data = JSON.parse(data);
            console.log(data);
            this.todos = data;
        })

    },

    data: {
        todos: [
           // {id: '5', description: 'supercewl', is_complete: false}
        ],
    },
    methods:{
        addTodo: function(){
            alert('todo added');
        },
        completeTodo: function(){
            alert('todo completes');
        },
        check: function(val){
            for (var i=0; i<this.selected.length; i++)
                if (this.selected[i] == val)
                    return true;
            return false;
        }

    }
});