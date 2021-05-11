/*
* Andy Le
* 000805099
* Loads and retrieves list of stocks and updates page
* I, Andy Le, 000805099 certify that this material is my original work. No other person's work has been used without due acknowledgement.
*/
window.addEventListener("load", function() {
	$(document).ready(function() {
		function success(stock) {
			$(".reset").remove();
			for (let i = 0; i < 10; i++) {
				let node = $("<tr>").append("<td>" + stock[i]["name"] + 
					"</td><td>$" + stock[i]["price"] + 
					"</td><td>" + stock[i]["time"] + 
					"</td>").addClass("reset");
				$("table").append(node);
			}
		}

		function success2(e) {
			let node = $("<p>").html(e).addClass("update");
			$("body").append(node);
		}

		setInterval(function(){
			let url = "data.php";
			fetch(url, { credentials: 'include' })
		        .then(response => response.json())
		        .then(success) 
	 	}, 1000);

	 	$("#submit").click(function() {
	 		$(".update").remove();
	 		$("#message").text("");
	 		let stockname1 = $("#stockname1").val();
			let stockprice1 = $("#stockprice1").val();
			let stocktime1 = $("#stocktime1").val();
			let stockname2 = $("#stockname2").val();
			let stockprice2 = $("#stockprice2").val();
			let stocktime2 = $("#stocktime2").val();
			let stockname3 = $("#stockname3").val();
			let stockprice3 = $("#stockprice3").val();
			let stocktime3 = $("#stocktime3").val();
			let valid1 = false;
			let valid2 = false;
			let valid3 = false;
			let valid = false;
			let stocklist = [];
			if (!((stockname1 == "") || (stockprice1 == "") || (stocktime1 == ""))) {
				valid1 = true;
				stocklist.push([stockname1, stockprice1, stocktime1]);
			} else {
				valid1 = false;
			}
			if (!((stockname2 == "") || (stockprice2 == "") || (stocktime2 == ""))) {
				valid2 = true;
				stocklist.push([stockname2, stockprice2, stocktime2]);
			} else {
				valid2 = false;
			}
			if (!((stockname3 == "") || (stockprice3 == "") || (stocktime3 == ""))) {
				valid3 = true;
				stocklist.push([stockname3, stockprice3, stocktime3]);
			} else {
				valid3 = false;
			}
			valid = valid1 || valid2 || valid3;
			if (valid) {
				for (item of stocklist) {
					let params = "stockname=" + item[0] +"&stockprice=" + item[1] + "&stocktime=" + item[2];
			 		fetch("add.php", {
			                method: 'POST',
			                credentials: 'include',
			                headers: { "Content-Type": "application/x-www-form-urlencoded" },
			                body: params
			            })
			            .then(response => response.text())
			            .then(success2)
				}
			} else {
				$("#message").text("Invalid Input");
			}	
	 	});
	});
	
})