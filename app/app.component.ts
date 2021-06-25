import { Component } from '@angular/core';
import { Order } from './order'; 
// import { OrdersService } from './order.service';

// wouldnt need to import http client because its in ordersservice  
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'Angular form and Validation';  
  
  drinks = ['cofee', 'tea', 'juice']; 
  
  // orderModel = new Order(); // one way of doing it 
  // order model couldve been named anything
  orderModel: Order; // variable of type Order (referencing class order.ts)
  // this is a variable belonging to AppComponent. 
  
  orderList: Array<Order> = [];   
  // array of customer orders 
  
  // "http" couldve been named anything, it's of type HttpClient
  constructor(private http: HttpClient){
  // constructor(private orderService: OrdersService){ // this is injecting dependency 
	  // this.orderModel = new Order("dud", "duh@uva.edu", 1112223333, "tea", "Cold", true); 
	  	  this.orderModel = new Order("", "", null, "", "", null); 

  }
  
  confirm_msg = '';
  confirmOrder(data: any): void {
     this.confirm_msg = "Thank you, " + data.monday + ".";
     this.confirm_msg += " You ordered " + data.drink_option + ".";
     if (data.sendtxt)
        this.confirm_msg += " We will text you once it's done.";
  }
  
  response: any; // defines a global variable to be used in onSubmit


  onSubmit(form: any): void {
	  // grab data from form 
	  // it will be inside a form object of any type 
	  // we need to prepare data before sending to backend. 
	  // can convert and send as json 
	  let params = JSON.stringify(form); 
	  // define variable params 
	  
	  // could call Order service instead of typing code here 
	  
	  // refer to the http variable of type HttpClient that we defined in 
	  // the constructor. 
	 // this.http.get<any>('http://localhost/my-ng-http-get.php?str='+params).subscribe( 
	 this.http.post<any>('http://localhost/my-ng-http-post.php', params)
	 .subscribe( 
	 (data)=>{
		// what to do with response 
	  this.response = data; 
	  },
	  (error) => {
		  // handle error 
		  console.log('Error ', error); 
	  }
	  );
	  // in this case we used a get request. uses url rewriting 
	  // in httpClient we put what type of data we're expecting to get back in < > 
	  // this subscribe button lets us get notified when the execution is complete 
	  // so the system doesnt have to wait here. it will return the response named 
	  // whatever you put in parenthesis. in this case we'll call it data 
	  // use the arrow function to tell it what to do once the data is ready 
	  
  }
  
  
  // submitted -> controller calls OrderService
  // Order Service does cleaning/preparing --> send request to php 
  // php returns to OrderService
  // OrderService returns to controller 
  
  
  onSubmit_orderList(form: any): void {
	  let form_entry = new Order(form.name, form.email, form.phone, 
	  form.drink_option, form.tempPreference, form.sendmsg);
	  // put in array of orders 
	  this.orderList.push(form_entry); 
	  
	  // grab data from form 
	  // it will be inside a form object of any type 
	  // we need to prepare data before sending to backend. 
	  // can convert and send as json 
	  let params = JSON.stringify(this.orderList); 
	  // define variable params 
	  
	  // refer to the http variable of type HttpClient that we defined in 
	  // the constructor. 
	 // this.http.get<any>('http://localhost/my-ng-http-get.php?str='+params).subscribe( 
	 this.http.post<any>('http://localhost/my-ng-http-post.php', params)
	 .subscribe( (data)=>{
		// what to do with response 
	  this.response = data; 
	  },
	  (error) => {
		  // handle error 
		  console.log('Error ', error); 
	  } )

	  // in this case we used a get request. uses url rewriting 
	  // in httpClient we put what type of data we're expecting to get back in < > 
	  // this subscribe button lets us get notified when the execution is complete 
	  // so the system doesnt have to wait here. it will return the response named 
	  // whatever you put in parenthesis. in this case we'll call it data 
	  // use the arrow function to tell it what to do once the data is ready 
	
/*
	// using the dumb service instead 
	this.orderService.processOrder(params) 
	.subscribe( (data) => {
		this.response = data; 
	}, (error) => {
		console.log('Error ', error); 
	}) 
*/ 
  }
} 
