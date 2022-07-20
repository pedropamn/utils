async function addElementToLocalstorageJSON(theLocalStorage, localStorageName, objectToAdd){
	
	//Parse JSON from localStorage
	var parsed = JSON.parse(theLocalStorage);
	
	//Push the object into the array
	parsed.push(objectToAdd);
	
	//Convert new array to JSON
	var newJson = JSON.stringify(parsed);
	
	//Save to localStorage
	localStorage.setItem(localStorageName, newJson);
}

async function removeElementToLocalStorageJSON(theLocalStorage, localStorageName, key, oldValueToSearch){
	//Parse JSON from localStorage
	var parsed = JSON.parse(theLocalStorage);
	
	for(var i=0; i <= parsed.length;i++){
		if(parsed[i][key] == oldValueToSearch){
			//Delete
			parsed.splice(i, 1);
			var deleted_index = i;
			break;
		}
	}
	
	//Convert new array to JSON
	var newJson = JSON.stringify(parsed);
	
	//Save to localStorage
	localStorage.setItem(localStorageName, newJson);
	
	return deleted_index;
}


function editElementToLocalstorageJSON(theLocalStorage, localStorageName, elementPositionToRemoveAndAdd, newElementObject){
	
	//Parse JSON from localStorage
	var parsed = JSON.parse(theLocalStorage);	
	
	//Remove and Add (Args: position to insert, how many to remove, object). That is: Insert 1 and remove 1 at same position
	parsed.splice(elementPositionToRemoveAndAdd, 1, newElementObject);

	//Convert new array to JSON
	var newJson = JSON.stringify(parsed);
	
	//Save to localStorage
	localStorage.setItem(localStorageName, newJson);

}


localStorage.teste = '[]';

//Adding	
var theObject = 
	{
		type:"Fiat", 	
		model:"500", 
		color:"white",
	};

var theObjectTwo = 
	{
		type:"Ford", 	
		model:"500", 
		color:"white2",
	};
	
var theObjectThree = 
	{
		type:"Volks", 	
		model:"500", 
		color:"white3",
	};


addElementToLocalstorageJSON(localStorage.teste, 'teste', theObject);
addElementToLocalstorageJSON(localStorage.teste, 'teste', theObjectTwo);
addElementToLocalstorageJSON(localStorage.teste, 'teste', theObjectThree);

localStorage.teste;

//Removing
removeElementToLocalStorageJSON(localStorage.teste, 'teste', 'type', 'Ford');

localStorage.teste;



//Editing (removing and inserting)
var theObjectTwo = 
	{
		type:"Tesla", 	
		model:"500", 
		color:"white2",
	};
	

editElementToLocalstorageJSON(localStorage.teste, 'teste', 1, theObjectTwo);

localStorage.teste;
