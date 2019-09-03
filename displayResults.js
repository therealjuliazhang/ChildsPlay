//needed for not putting padding-top on first header
var firstHeader = true;

// display results for identify body part 
function displayBody(bodyResults){
    taskIDs = getUniqueIDs(bodyResults);
    displayResults(bodyResults, taskIDs, "Identify Body Parts");
}
//display results for character ranking
function displayRanking(rankingResults){
    taskIDs = getUniqueIDs(rankingResults);
    displayResults(rankingResults, taskIDs, "Character Ranking", );
}
// display results for likert scale
function displayLikert(likertResults){
    taskIDs = getUniqueIDs(likertResults);
    displayResults(likertResults, taskIDs, "Likert Scale");
}
//display results for preferred mechanics
function displayMechanics(mechanicResults){
    taskIDs = getUniqueIDs(mechanicResults);
    displayResults(mechanicResults, taskIDs, "Preferred Mechanics");
}
//get all unique task IDs from results
function getUniqueIDs(results){
    taskIDs = [...new Set(results.map(item => item.taskID))];
    return taskIDs;
}
//display results for one task
function displayResults(results, taskIDs, taskType){
    taskIDs.forEach(function(taskID){
        //get only the results for this task ID
        var taskResults = results.filter(function(result){
            return result['taskID'] == taskID;
        });
        //displays headers for each task results
        displayHeaders(taskID, taskResults, taskType);
        //displays graph results if likert or mechanics task
        displayGraph(taskResults, taskType);
        //display ranking table if character ranking task
        if(taskType == "Character Ranking")
            displayRankingTable(taskResults);
        //display image results for body parts 
        if(taskType == "Identify Body Parts")
            displayBodyPartResult(taskResults);
    });
}
//displays headers for results and image if likert or mechanics task
function displayHeaders(taskID, taskResults, taskType){
    //if first header dont add padding-top, else put padding
    if(firstHeader){
        $('<h5/>', {
            class: "blue-text darken-2 header",
            text: taskType + " - Task ID: " + taskID
        }).appendTo('#results');  
        firstHeader = false; 
    }
    else{
        $('<h5/>', {
            class: "blue-text darken-2 header topPadding",
            text: taskType + " - Task ID: " + taskID
        }).appendTo('#results');   
    }
    $('<h6/>', {
        class: "blue-text darken-2 header",
        text: "Activity: " + taskResults[0]['activity']
    }).appendTo('#results'); 
    //display image if likert or mechanics task  
    if(taskType == "Likert Scale" || taskType == "Preferred Mechanics"){
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
function displayGraph(taskResults, taskType){
    if(taskType == "Likert Scale" || taskType == "Preferred Mechanics"){
        $('<canvas/>', {
            width: "800px",
            text: "CanvasNotSupported"
        }).appendTo('#results');
        var ctx = $("canvas").last()[0].getContext('2d');
        //create labels and data
        var labels = []; 
        var data = [];
        //get labels and data
        if(taskType == "Likert Scale"){
            $.each(taskResults, function( index, value ) {
                if(value['happy'] == "0")
                    labels.push("Dislike");
                else if(value['happy'] == "1")
                    labels.push("Like");
                data.push(value['likertCount']);
            });
        }
        else if(taskType == "Preferred Mechanics"){
            $.each(taskResults, function( index, value ) {
                labels.push(value['mechanic']);
                data.push(value['mechanicCount']);
            });
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
    // var commentsDiv = "<div class=\"row\"><form class=\"col s12\"><div class=\"input-field col s8\">";
    // var textArea = "<textarea id=\"textarea1\" class=\"materialize-textarea\"";
    // console.log(results);
    // if(task.comments != null){
    //     textArea += " value=" + task.comments;
    // }
    // textArea += "></textarea><label for=\"textarea1\">Comments</label></div></form></div><div class=\"row\"><form class=\"col s12\"><div class=\"input-field col s8\>";
    // commentsDiv += textArea;
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
        width: "400px",
        //400 * 0.35
        height: "200px",
        text: "CanvasNotSupported"
    }).appendTo('#results');
    var ctx = $("canvas").last()[0].getContext('2d');
    //draw image
    var img = new Image();
      img.src = results[0].address;
      img.onload =function() {
        scaleToFill(this, ctx);
      };
   // ctx.drawImage(img,0,0);
    //draw point
    
   // ctx.fillRect(20,20,2,2);
   // ctx.fillRect(50,50,2,2);
  //  ctx.fillRect(200,200,2,2);
    //ctx.arc(100,100, 1, 3, 2 * Math.PI, true);
    //ctx.arc(90,120, 1, 3, 2 * Math.PI, true);
    
    console.log(results[0].address);
    console.log(results[0].y / 15);
    ctx.fill();
    results.forEach(function(result){
        //ctx.restore();
        var xCoord = result.x * 0.5;
        var yCoord = result.y * 0.5;
        ctx.beginPath();
        ctx.arc(xCoord, yCoord, 3, 0, Math.PI*2, true);
        ctx.closePath();
        ctx.fill();  
        console.log(xCoord);
        console.log(yCoord);
    }); 
    
}

function scaleToFill(img, ctx){

   
    // get the scale
    var scale = Math.min($("canvas").last()[0].width / img.width, $("canvas").last()[0].height / img.height);
    // get the top left position of the image
    var x = ($("canvas").last()[0].width / 2) - (img.width / 2) * scale;
    var y = ($("canvas").last()[0].height / 2) - (img.height / 2) * scale;

    ctx.imageSmoothingEnabled = false; 
    ctx.webkitImageSmoothingEnabled = false;
    ctx.mozImageSmoothingEnabled = false;

    ctx.drawImage(img, x, y, img.width * scale, img.height * scale);
    
}

