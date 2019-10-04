//needed for not putting padding-top on first header
var firstHeader = true;
//display all results for one activity style
function displayResults(results, isGroupResults){
    taskIDs = [...new Set(results.map(item => item.taskID))];
    taskIDs.forEach(function(taskID){
        //get only the results for this task ID
        var taskResults = results.filter(function(result){
            return result['taskID'] == taskID;
        });
        //get activity style
        var activityStyle = getTaskType(taskResults[0]);
        //displays headers for each task results
        displayHeaders(taskID, taskResults, activityStyle);
        //displays graph results if likert or mechanics task
        displayGraph(taskResults, activityStyle);
        //display preferred mechanics "other" option comments
        if(activityStyle == "Preferred Mechanics")
            displayOtherComments(taskResults);
        //display ranking table if character ranking task
        if(activityStyle == "Character Ranking")
            displayRankingTable(taskResults);
        //display image results for body parts 
        if(activityStyle == "Identify Body Parts")
            displayBodyPartResult(taskResults);
        //display comments if displaying group results
        if(isGroupResults)
            displayComments(taskResults);
    });
}
//get task type of task result
function getTaskType(result){
    var taskType;
    if(result.hasOwnProperty("x"))
        taskType = "Identify Body Parts";
    else if(result.hasOwnProperty("totalScore"))
        taskType = "Character Ranking";
    else if(result.hasOwnProperty("happy"))
        taskType = "Likert Scale";
    else if(result.hasOwnProperty("mechanic"))
        taskType = "Preferred Mechanics";
    return taskType;
}
//displays headers for results and image if likert or mechanics task
function displayHeaders(taskID, taskResults, activityStyle){
    //if first header dont add padding-top, else put padding
    if(firstHeader){
        $('<h5/>', {
            class: "blue-text darken-2 header",
            text: activityStyle + " - Task ID: " + taskID
        }).appendTo('#results');  
        firstHeader = false; 
    }
    else{
        $('<h5/>', {
            class: "blue-text darken-2 header topPadding",
            text: activityStyle + " - Task ID: " + taskID
        }).appendTo('#results');   
    }
    $('<h6/>', {
        class: "blue-text darken-2 header",
        text: "Instruction: " + taskResults[0]["instruction"]
    }).appendTo('#results'); 
    //display image if likert or mechanics task  
    if(activityStyle == "Likert Scale" || activityStyle == "Preferred Mechanics"){
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
}
//displays results graph if likert or mechanics task
function displayGraph(taskResults, activityStyle){
    if(activityStyle == "Likert Scale" || activityStyle == "Preferred Mechanics"){
        $('<canvas/>', {
            width: "800px",
            text: "CanvasNotSupported"
        }).appendTo('#results');
        var ctx = $("canvas").last()[0].getContext('2d');
        //create labels and data
        var labels = []; 
        var data = [];
        //get labels and data
        var noLikes = true;
        var noDislikes = true;
        if(activityStyle == "Likert Scale"){
            $.each(taskResults, function( index, value ) {
                if(value['happy'] == "0"){
                    labels.push("Dislike");
                    noDislikes = false;
                }
                else if(value['happy'] == "1"){
                    labels.push("Like");
                    noLikes = false;
                }
                data.push(value['likertCount']);
            });
            if(noDislikes){
                labels.push("Dislike");
                data.push(0);
            }
            if(noLikes){
                labels.push("Like");
                data.push(0);
            }
        }
        else if(activityStyle == "Preferred Mechanics"){
            var noPress = true;
            var noZoom = true;
            var noSwipe = true;
            $.each(taskResults, function( index, value ) {
                switch(value['mechanic']){
                    case 'Press':
                        noPress = false;
                        break;
                    case 'Zoom/Pinch':
                        noZoom = false;
                        break;
                    case 'Swipe/Drag':
                        noSwipe = false;
                        break;
                }
                labels.push(value['mechanic']);
                data.push(value['mechanicCount']);
            });
            if(noPress){
                labels.push('Press');
                data.push(0);
            }
            if(noZoom){
                labels.push('Zoom/Pinch');
                data.push(0);
            }
            if(noSwipe){
                labels.push('Swipe/Drag');
                data.push(0);
            }
        }
        setGraphData(ctx, labels, data);
    }
}
//sets data to graph results
function setGraphData(ctx, labels, data){
    //set the chart data
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
//displays the table of rankings for one character ranking task
function displayRankingTable(results){
    var tableHeader = "<div id=\"tableDiv\"><table class=\"centered\"><thead><tr><th>Rank: </th><th>Points: </th><th>Image: </th></tr></thead>";
    var tableBody = "<tbody>" + createTableRows(results) + "</tbody></table></div>";
    var table = tableHeader + tableBody;
    $("#results").append(table); 
}

//create html for the ranking results table rows
function createTableRows(results){
    var rankNumber = 0;
    var html = "";
    results.forEach(function(result){
        rankNumber++;
        var rank = rank_of(rankNumber);
        html += "<tr><td>" + rank + "</td>";
        html += "<td>" + result.totalScore + "</td>";
        html += "<td><img class=\"image\" src=\"" + result.address + "\" style=\"width:15%;\"></td></tr>";
    });
    return html;
    //convert rank number to ordinal suffix e.g. 1 to 1st
    function rank_of(number) {
        var j = number % 10,
            k = number % 100;
        if (j == 1 && k != 11) {
            return number + "st";
        }
        if (j == 2 && k != 12) {
            return number + "nd";
        }
        if (j == 3 && k != 13) {
            return number + "rd";
        }
        return number + "th";
    }
    
}

function displayBodyPartResult(results){
    //make canvas 
    $('<canvas/>', {
        //800 * 0.35
        width: "15%",
        //400 * 0.35
        // height: "297px",
        text: "CanvasNotSupported",
        stlye: "border:1px solid #d3d3d3;"
    }).appendTo('#results');
    //set image onto canvas
    var img = new Image();
    img.src = results[0].address;
    var canvas = $("canvas").last()[0];
    context = canvas.getContext('2d');
    img.onload = function() {
        //get ratio of width to height of image
        var ratio = img.height/img.width;
        //set height of canvas so that canvas is to scale
        canvas.height = canvas.width * ratio;
        //draw image on canvas
        context.drawImage(img, 0,0, canvas.width, canvas.height);
        //set color of dots
        context.fillStyle = 'red';
        //draw dots
        results.forEach(function(result){
            context.beginPath();
            context.arc(canvas.width * result.x, canvas.height * result.y, 7, 0, 2 * Math.PI);
            // context.arc(30, 30, 5, 0, 2 * Math.PI, true);
            context.stroke();
            // context.closePath();
            context.fill();
        })
    }
}

//display the comments for the task
function displayComments(taskResults){
    $('<div/>', { class: "row" })
    .append($('<form/>', { class: "col s12" }))
    .append($('<div/>', { class: "input-field col s8" }))
    .append([$('<textarea/>', { class: "materialize-textarea", id:"textarea1", text: taskResults[0].comments}), $('<label/>', { for: "textarea1", class:"materialize-textarea", text:"Comments" })])
    .appendTo('#results'); 
    M.textareaAutoResize($('#textarea1'));
}

//display preferred mechanics "other" option comments
function displayOtherComments(taskResults){
    taskResults.forEach(function(results){
        if(results.otherComment != null){
            $('<div/>', { class: "row" })
            .append($('<form/>', { class: "col s12" }))
            .append($('<div/>', { class: "input-field col s8" }))
            .append([$('<textarea/>', { class: "materialize-textarea", id:"textarea2", text: results.otherComment}), $('<label/>', { for: "textarea2", class:"materialize-textarea", text:"Other Mechanic" })])
            .appendTo('#results'); 
            M.textareaAutoResize($('#textarea2'));
        }
    });
}
