import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http'
import { Observable, throwError } from 'rxjs'; 

@Injectable({
  providedIn: 'root'
})
export class OrdersService {

  constructor(private http: HttpClient) { }
  
  sendRequest(data: any): Observable<any>{
	  return this.http.post<any>('http://localhost/my-ng-http-post.php', data);

  }
  
  processOrder(data: any): Observable<any>{
	  // receives data of type any 
	  // returns observable of type any 
	  
	  // data cleaning, processing 
	  // send request to backend (php) 
	  return this.sendRequest(data); 
  }
}
