class Store{
    constructor(){
        this.list = [];
        this.maplist = {};
        this.basketList = [];
        this.basket_list = document.querySelector("#basket_list");
        this.drop_area = document.querySelector("#drop_area");
        this.basket_price = document.querySelector("#basket_price");
        this.store_list = document.querySelector("#store_list");
        this.search_form = document.querySelector("#search_form");

        fetch("resources/json/store.json")
        .then(res=>res.json())
        .then(data=>this.setting(data))
    }

    setting(data){
        data.forEach(x=>{
            x.price_num = parseInt(x.price.replace(/,/g,""));
            x.num = 1;
            this.StoreItemMake(x);
        });
        this.list = data;
        this.maplist = this.list.reduce((r,s)=>({...r,[s.id]:s}),{});
    }

    StoreItemMake({id,price,product_name,brand}){

    }

}

window.onload=()=>{
    let store = new Store();
}