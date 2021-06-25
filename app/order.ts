export class Order {
	constructor(
		public name: string, 
		public email: string, 
		public phone: number | null,
		public drink: string,
		public tempPreference: string,
		public sendText: boolean | null   
		){}
}
