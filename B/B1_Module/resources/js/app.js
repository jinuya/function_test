class App{
    constructor(){
        this.itemList = []; //아이템 리스트
        this.itemListMap = {};
        this.item_price = 0;
        this.basket = []; //장바구니
        this.search_box = document.querySelector("#search_form");
        this.item_drop = document.querySelector("#item_drop");
        this.pricebox = document.querySelector("#item_allprice");
        this.basket_btn = document.querySelector("#item_allprice_btn");
        this.itemlist_area = document.querySelector("#item_list");
        this.basket_area = document.querySelector("#item_box_list");
        this.buy_btn = document.querySelector("#buy_btn");
        this.cho = ["ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ"];
        fetch("resources/json/store.json")
        .then(res => res.json())
        .then(data => this.setting(data));
    }

    setting(data){
        this.itemlist_area.innerHTML = "";
        this.itemList = data;
        this.itemList.forEach(x =>{
            x.priceNum = parseInt(x.price.replace(/,/g,''));
            x.cho_product_name = this.getChosung(x.product_name);
            x.cho_brand = this.getChosung(x.brand);
            x.number = 1;
            this.MakeItem(x);
        });
        this.itemListMap = data.reduce((r,x)=>({...r,[x.id]:x}),{});
        this.item_drop.addEventListener("drop",this.dropHandle);
        this.item_drop.addEventListener("dragover",this.drop);
        if(!this.basket.length) this.basket_area.innerHTML = "";
        else this.basket.forEach(x =>{this.MakeBasketItem(x)});
        this.search_box.addEventListener("keyup",this.search);
        this.buy_btn.addEventListener("click",this.Buybasket);
    }

    MakeItem(data){
        let item = document.createElement("div");
        item.classList.add("item");
        item.innerHTML = `
        <div class="item_img">
            <img src="resources/images/${data.photo}" alt="item_img" title="item_img" draggable = "true">
        </div>
        <div class="item_info">
            <p class="item_name">${data.product_name}</p>
            <p class="item_brand">${data.brand}</p>
            <p class="item_price">${data.price} 원</p>
        </div>`;
        item.querySelector("img").addEventListener("dragstart",this.dragHandle);
        item.setAttribute("id",data.id);
        this.itemlist_area.appendChild(item);
    }

    getChosung(name){
        let result = "";
        for(let i = 0; i< name.length; i++){
            let tmp = name[i].charCodeAt() - 0xAC00;
            let last = tmp % 28; //종성
            let mid = ((tmp - last) / 28) % 21; // 중성
            let first = (((tmp - last) / 28) - mid) /21 //초성
            if(this.cho[first] !== undefined)result += this.cho[first];
        }
        return result;
    }

    dragHandle=e=>{
        let idx = e.target.parentElement.parentElement.id;
        e.dataTransfer.setData("idx",idx);
    }

    drop=e=>{e.preventDefault();}
    dropHandle = e =>{
        e.preventDefault();
        let idx = e.dataTransfer.getData("idx");
        if(idx !== "") this.addBasket(idx);
    }

    addBasket(idx){
        if(this.basket.find(item => item == idx)) return alert("이미 장바구니에 담긴 상품입니다.");
        let item = this.itemListMap[idx];
        this.basket.push(item.id);
        this.BasketAllPrice();
        this.MakeBasketItem(item);
    }

    MakeBasketItem(data){
        let item = document.createElement("div");
        item.classList.add("item");
        item.innerHTML =`<button class="item_box_del" data-id="${data.id}" ><i class="fa fa-close" data-id="${data.id}"></i></button>
        <div class="item_img">
            <img src="resources/images/${data.photo}" title="item_img" alt="item_img">
        </div>
        <div class="item_info">
            <p class="item_number_box">수량 : <input type="number" class="item_number" value="${data.number}" data-id="${data.id}" min="1"></p>
            <p class="item_name">${data.product_name}</p>
            <p class="item_brand">${data.brand}</p>
            <p class="item_price">${data.price} 원</p>
        </div>`;
        item.querySelector(".item_number").addEventListener("change",this.BasketItemNumber);
        item.querySelector(".item_box_del").addEventListener("click",this.BasketItemDel);
        this.basket_area.appendChild(item);
    }

    BasketItemDel = e =>{
        let idx = e.target.getAttribute("data-id");
        let slice_idx = this.basket.findIndex(x=>x == idx);
        this.basket.splice(slice_idx,1)
        this.basket_area.innerHTML = "";
        this.basket.forEach(x => this.MakeBasketItem(this.itemListMap[x]));
        this.BasketAllPrice();
    }

    BasketItemNumber = e =>{
        let value = e.target.value,idx = e.target.getAttribute("data-id");
        this.itemListMap[idx].number = value;
        this.BasketAllPrice();
    }

    BasketAllPrice(){
        let price = 0;
        this.basket.forEach(x=>{price += (this.itemListMap[x].priceNum * this.itemListMap[x].number)});
        this.pricebox.innerHTML = this.PriceMakeStr(price);
    }

    PriceMakeStr(price){
        let price_string = "";
        price = price+"";
        while(1){
            if(price.length < 4) break;
            price_string = price.substr(price.length-3,3)+","+price_string;
            price = price.substr(0,price.length-3);
        }
        price_string = price+","+price_string;
        price_string = price_string.substring(0,price_string.length-1);        
        return price_string;
    }

    Buybasket=e=>{
        let buyer_name = document.querySelector("#buyer_name"),buyer_address = document.querySelector("#buyer_address");
        if(buyer_name.value == "") return alert("이름을 입력해주세요.");
        if(buyer_address.value == "") return alert("주소를 입력해주세요.");
        $("#buy_close").trigger("click");
        buyer_name.value = "";
        buyer_address.value = "";
        this.basket_area.innerHTML = "";
        this.pricebox.innerHTML = 0;
        this.MakeReceipt();
    }

    MakeReceipt(){
        const canvas = document.querySelector("#receipt");
        const ctx = canvas.getContext("2d");
        let fontSize = 25,receipt_list = [],item;
        ctx.font = fontSize + "px Arial";

        let maxString = "";
        if(this.basket.length > 0){
            this.basket.forEach(x => {
                item = this.itemListMap[x];
                item.sum = this.itemListMap[x].number * this.itemListMap[x].priceNum;
                receipt_list.push(item);
                if(item.product_name.length > maxString.length) maxString = item.product_name;
            });
        }
        
        let offset = 10;
        let width = ctx.measureText(maxString).width;
        canvas.height = fontSize * (receipt_list.length + 5);
        canvas.width = width + 200;
        let allprice = 0;
        // 영수증 그리기 시작
        ctx.clearRect(0,0,canvas.width,canvas.height); // <- 캔버스 초기화
        for(let i = 0; i<receipt_list.length; i++){
            let item = receipt_list[i];
            ctx.fillText(item.product_name,offset,(i+1) * fontSize + offset * i)//제품명
            let infoText = `${item.price}, ${item.number}, ${this.PriceMakeStr(item.sum)}`;
            ctx.fillText(infoText,2*offset + width, (i+1) * fontSize + offset * i);
            allprice += item.sum; 
        }

        let now = new Date();
        let lastString = `총합계 : ${allprice}, 구매일시 : ${now.getFullYear()}-${now.getMonth()}-${now.getDate()} ${now.toLocaleTimeString().substring(3)}`;
        ctx.fillText(lastString,offset,(receipt_list.length+1)*fontSize + offset * receipt_list.length);

        $("#recepit_open").trigger("click");
        this.basket = {};
    }

    // 검색....
    search = e =>{
        let val = e.target.value;
        let list = this.itemList,newList = [];
        let flag = false;
        this.itemlist_area.innerHTML = "";
        if(val !== ""){
            if(this.cho.includes(val)){
                list.forEach(x => {
                    flag = false;
                    let {id,photo,brand,product_name,price,priceNum,cho_product_name,cho_brand,number} = x;
                    // 상품명
                    if(cho_product_name.includes(val)){
                        let idx = cho_product_name.indexOf(val);
                        product_name = `${product_name.substring(0,idx)}<mark>${product_name.substring(idx,idx+val.length)}</mark>${product_name.substring(idx+val.length,product_name.length)}`;
                        flag = true;
                    }
                    // 브랜드
                    if(cho_brand.includes(val)){
                        let idx = cho_brand.indexOf(val);
                        brand = `${brand.substring(0,idx)}<mark>${brand.substring(idx,idx+val.length)}</mark>${brand.substring(idx+val.length,brand.length)}`;
                        flag = true;
                    }
                    if(flag) newList.push({id,photo,brand,product_name,price,priceNum,cho_product_name,cho_brand,number});
                });
            }else{
                list.forEach(x => {
                    flag = false;
                    let {id,photo,brand,product_name,price,priceNum,cho_product_name,cho_brand,number} = x;
                    // 그냥검색
                    // 상품명
                    if(product_name.includes(val)){
                        let idx = product_name.indexOf(val);
                        product_name = `${product_name.substring(0,idx)}<mark>${product_name.substring(idx,idx+val.length)}</mark>${product_name.substring(idx+val.length,product_name.length)}`;
                        flag = true;
                    }
                    // 브랜드
                    if(brand.includes(val)){
                        let idx = brand.indexOf(val);
                        brand = `${brand.substring(0,idx)}<mark>${brand.substring(idx,idx+val.length)}</mark>${brand.substring(idx+val.length,brand.length)}`;
                        flag = true;
                    }
                    if(flag) newList.push({id,photo,brand,product_name,price,priceNum,cho_product_name,cho_brand,number});
                });
            }
            if(newList.length > 0) newList.forEach(item => {this.MakeItem(item)});
            else this.itemlist_area.innerHTML = "<p id='search_notfound'>일치하는 상품이 없습니다.</p>"
        }else list.forEach(item => {this.MakeItem(item)});
    }
}

window.onload = ()=>{
    let app = new App();
}