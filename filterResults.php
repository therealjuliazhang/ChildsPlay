<?php
echo $countHappy;



/*------------------------------------------------GROUP FILTER WITH LOCATION, GROUP, GENDER AND AGE------------------------------------------------------------------------*/	
								if(isset($_POST["action"])){ //Check if "Sort" button is clicked
									$countSad = 0;
									$countHappy = 0;
									//check if any location option is selected
									if(isset($_POST["location"])){
										$i = 0;
										$countIDs = count($_POST["location"]);
										$selected = "";
										while($i < $countIDs){
											$selected .= $_POST["location"][$i];
											if($i < $countIDs - 1){
												$selected .= ",";
											}
											$i++;
										}
										//echo $selected;
										$locationSql = "SELECT groupID FROM GROUPTEST WHERE locationID IN (".$selected.")";
										//check if any group option is selected
										if(isset($_POST["group"])){
											$i = 0;
											$countIDs = count($_POST["group"]);
											$selected = "";
											
											while($i < $countIDs){
												$selected .= $_POST["group"][$i];
												if($i < $countIDs - 1){
													$selected .= ",";
												}
												$i++;
											}
											//echo $selected;
											$locationSql .= " AND groupID IN (".$selected.")";
										}
										$locationResult = $conn->query($locationSql);
										
										while($row = mysqli_fetch_assoc($locationResult)){
											$sql1 = "SELECT preID FROM GROUPASSIGNMENT WHERE groupID=".$row["groupID"];
											$result1 = $conn->query($sql1);
											$preIDs = array();
											
											$preArray = array();
											
											while($v=mysqli_fetch_assoc($result1)){
												$preIDs = $v["preID"];
											}
											//check if any gender option is selected
											if(isset($_POST["gender"])){
												$i = 0;
												$countIDs = count($_POST["gender"]);
												$selected = "";
												
												while($i < $countIDs){
													$selected .= $_POST["gender"][$i];
													if($i < $countIDs - 1){
														$selected .= ",";
													}
													$i++;
												}
												echo $selected;
												$preSql = "SELECT preID FROM PRESCHOOLER WHERE gender IN (".$selected.")";
												//check if any age option is selected
												if(isset($_POST["age"])){
													$i = 0;
													$countIDs = count($_POST["age"]);
													$selected = "";
													while($i < $countIDs){
														$selected .= $_POST["age"][$i];
														if($i < $countIDs - 1){
															$selected .= ",";
														}
														$i++;
													}
													$preSql .= "AND age IN (".$selected.")";
												}
												
												$preResult = $conn->query($preSql);
												
												$sortedPreIDs = array();
												$index = 0;
												while ($row = mysqli_fetch_assoc($preResult)){
													if($preIDs[$index] == $row["preID"]){
														array_push($sortedPreIDs, $row["preID"]);
														$index++;
													}
												}
												$preArray = $sortedPreIDs;
												echo "Check1: ".$sortedPreIDs;
											}
											else
												$preArray = $preIDs; //case when no gender option is selected
										
											echo "Check2: ".$preIDs;
											
											foreach($preArray as $v){
												$resultQuery = "SELECT happy FROM RESULTS WHERE testID=".$testID." AND taskID=".$value["taskID"]." AND preID=".$v["preID"];
												$result2 = $conn->query($resultQuery);
												while($row2 = mysqli_fetch_assoc($result2)){
													if($row2["happy"] == false){
														$countSad++;
													}
													else if($row2["happy"] == true){
														$countHappy++;
													}
												}	
											}
										}
									}
/*------------------------------------------------SINGLE FILTER WITH GROUP, GENDER AND AGE------------------------------------------------------------------------*/
									//check if any group option is selected
									if(isset($_POST["group"])){
										$i = 0;
										$countIDs = count($_POST["group"]);
										$selected = "";											
										while($i < $countIDs){
											$selected .= $_POST["group"][$i];
											$sql1 = "SELECT preID FROM GROUPASSIGNMENT WHERE groupID=".$selected;
											$result1 = $conn->query($sql1);
											while($v=mysqli_fetch_assoc($result1)){
												$resultQuery = "SELECT happy FROM RESULTS WHERE testID=".$testID." AND taskID=".$value["taskID"]." AND preID=".$v["preID"];
												$result2 = $conn->query($resultQuery);
												while($row2 = mysqli_fetch_assoc($result2)){
													if($row2["happy"] == false){
														$countSad++;
													}
													else if($row2["happy"] == true){
														$countHappy++;
													}
												}			
											}
											$i++;
										}
									}
								}
?>