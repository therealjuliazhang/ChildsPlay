//display results for character ranking
function displayRanking(rankingResults){
    taskIDs = getUniqueIDs(rankingResults);
    displayResults(rankingResults, taskIDs, "ranking");
}
// display results for likert scale
function displayLikert(likertResults){
    taskIDs = getUniqueIDs(likertResults);
    displayResults(likertResults, taskIDs, "likertScale");
}
//display results for preferred mechanics
function displayMechanics(mechanicResults){
    taskIDs = getUniqueIDs(mechanicResults);
    displayResults(mechanicResults, taskIDs, "mechanics");
}
//get all unique task IDs from results
function getUniqueIDs(results){
    taskIDs = [...new Set(results.map(item => item.taskID))];
    return taskIDs;
}
//display results for task
function displayResults(results, taskIDs, taskType){
    taskIDs.forEach(function(taskID){
        //get only the results for this task ID
        var taskResults = results.filter(function(result){
            return result['taskID'] == taskID;
        });
        $('<h5/>', {
            class: "blue-text darken-2 header",
            text: "Character Ranking - Task ID: " + taskID
        }).appendTo('#results');   
        $('<h6/>', {
            class: "blue-text darken-2 header",
            text: "Activity: " + taskResults[0]['activity']
        }).appendTo('#results');   
        if(taskType != "ranking"){
            $('<img/>', {
                class: "image",
                src: taskResults[0]['address'],
                style: "width:15%;"
            }).appendTo('#results');
        }
        $('<h5/>', {
            class: "blue-text darken-2 header",
            text: "Results"
        }).appendTo('#results');  
        if(taskType == "likertScale" || taskType == "mechanics"){
            $('<canvas/>', {
                width: "800px",
                text: "CanvasNotSupported"
            }).appendTo('#results');
            var ctx = $("canvas").last()[0].getContext('2d');
            //create labels and data
            var labels = []; 
            var data = [];
            if(taskType == "likertScale"){
                $.each(taskResults, function( index, value ) {
                    if(value['happy'] == "0")
                        labels.push("Dislike");
                    else if(value['happy'] == "1")
                        labels.push("Like");
                    data.push(value['likertCount']);
                });
            }
            else if(taskType == "mechanics"){
                $.each(taskResults, function( index, value ) {
                    labels.push(value['mechanic']);
                    data.push(value['mechanicCount']);
                });
            }
            var chart = new Chart(ctx, {
                type: "horizontalBar", // Make the graph horizontal
                data: {
                labels:  labels,
                datasets: [{
                label: "Number of Answers",
                data: data,
                backgroundColor: ['rgba(255, 159, 64, 0.2)',
                'rgba(153, 102, 255, 0.2)'],
                borderColor:['rgba(255, 159, 64, 1)',
                'rgba(153, 102, 255, 1)'],
                borderWidth: 1
                }]},
                options: {
                    responsive: false,
                    title: {
                    display: true,
                    fontSize: 15,
                    text: "Results"
                    },
                    legend: {
                        //position: 'right',
                    display: false,
                    },
                    scales: {
                        xAxes: [{ // Ｘ Axes Option
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }}],
                        yAxes: []
                    }
                }
            });
        }
    });
}