class store{
    constructor(){
        this.list = [];
        this.maplist = {};
        this.basket = document.querySelector("#basket_price");
        this.basketList = [];
        this.basket_list = document.querySelector("#basket_list");
        this.item_list = document.querySelector("#store_list");
        this.drop_area = document.querySelector("#drop_area");

        this.setting();
    }

    setting(){
        this.item_list.innerHTML = "";
        fetch("resources/json/store.json")
        .then(res => res.json())
        .then(data => this.setList(data));

        this.basket_list.innerHTML = "";
        this.basketList = [];
        this.basket.innerHTML = "0";
        document.querySelector("#basket_sell").addEventListener("click",this.basket_sell);
    }

    basket_sell=e=>{
        const form = document.basket_form;
        if(this.basketList.length == 0) return alert("살 물건이 없습니다.");
        if(form.name.value == "" || form.port.value == "") return alert("내용을 입력해주세요.");
        $("#basket_popup_close").trigger("click");

        const canvas = document.querySelector("#recepit");
        const ctx = canvas.getContext("2d");
        ctx.font = "20px Arial";

        let maxlength = "",maxprice = "",maxnum = "",maxsum = "",sum = 0,list = [];

        this.basketList.forEach(x=>{
            let item = this.maplist[x];
            item.sum = (item.price_num * item.num);
            sum += (item.price_num * item.num);
            if(item.product_name.length > maxlength.length) maxlength = item.product_name;
            if(item.price.length > maxprice.length) maxprice = item.price;
            if(item.num+"".length > maxnum.length) maxnum = item.num+"";
            if(item.sum+"".length > maxsum.length) maxsum = item.sum+"";
            console.log(maxprice);
            list.push(item);
        });

        let fontSize = 20,offset = 10,base_space = 100,maxwidth = ctx.measureText(maxlength).width,maxpricewidth = ctx.measureText(maxprice).width,maxnumwidth = ctx.measureText(maxnum).width,maxsumwidth = ctx.measureText(maxsum).width;

        canvas.width = maxwidth + base_space + maxpricewidth + maxnumwidth + maxsumwidth+100;
        canvas.height = (list.length *( fontSize + offset)) + offset*10;

        let left = offset,top = fontSize+offset;
        ctx.fillText("상품명",left,top);
        left+=maxwidth+base_space;
        ctx.fillText("가격",left,top);
        left+=maxpricewidth+offset+offset;
        ctx.fillText("수량",left,top);
        left+=(5*offset)+maxnumwidth;
        ctx.fillText("합계",left,top);

        ctx.beginPath();
        ctx.moveTo(offset,top+(offset + offset/2));
        ctx.lineTo(canvas.width - offset,top+(offset + offset/2));
        ctx.stroke();

        top+=offset;
        for(let i = 0; i<list.length;i++){
            let item = list[i];
            top += fontSize+offset;
            left = offset;

            ctx.fillText(item.product_name,left,top);
            left+=maxwidth+base_space;
            ctx.fillText(item.price+"원",left,top);
            left+=maxpricewidth+offset+offset;
            ctx.fillText(item.num+"개",left,top);
            left+=(5*offset)+maxnumwidth;
            ctx.fillText(this.price_type(item.sum)+"원",left,top);
        }
        top +=offset;
        ctx.beginPath();
        ctx.moveTo(offset,top);
        ctx.lineTo(canvas.width-offset,top);
        ctx.stroke();

        top +=offset*2;

        let now = new Date();

        ctx.fillText(`총합계 : ${this.price_type(sum)}원`,offset,top);
        let info = `구매일시 : ${now.getFullYear()}-${now.getMonth()}-${now.getDay()} ${now.toLocaleTimeString(3)}`;
        ctx.fillText(info,canvas.width - offset - ctx.measureText(info).width,top);

        $("#recepit_open").trigger("click");
    }

    setList(list){
        list.forEach(item =>{
            item.price_num = parseInt(item.price.replace(/,/g,""));
            item.num = 1;
            this.makeItem(item);
        });
        this.maplist = list.reduce((r,x)=>({...r,[x.id]:x}),{});
        this.drop_area.addEventListener("drop",this.dropHandle);
        this.drop_area.addEventListener("dragover",this.drop);
    }

    basketAdd(id){
        let flag = true;
        this.basketList.find((x)=>{if(x == id) flag = false;});
        if(!flag) return alert("이미 장바구니에 담긴 상품입니다.");
        this.basketList.push(id);
        this.makeBasket();
    }

    basketprice(){
        let sum = 0;
        this.basketList.forEach(x=>{sum+=(this.maplist[x].price_num * this.maplist[x].num);});
        this.basket.innerHTML = this.price_type(sum);
    }

    makeBasket(){
        this.basket_list.innerHTML="";
        this.basketList.forEach((id,num)=>{
            let tr = document.createElement("tr");
            let x = this.maplist[id];
            tr.innerHTML = `<td>${num+1}</td>
                            <td><img src="resources/images/${x.photo}" alt="basket_img" title="basket_img" class="basket_img"></td>
                            <td>${x.product_name}</td>
                            <td>${x.brand}</td>
                            <td>${x.price} 원</td>
                            <td><input class="form-control w-25" data-id="${x.id}" min="1" value="${x.num}" ></td>
                            <td>${this.price_type((x.price_num) * (x.num))} 원</td>
                            <td><button class="close basket_del" data-id="${x.id}">&times;</button></td>`;
            tr.querySelector(".basket_del").addEventListener("click",this.basket_del);
            tr.querySelector("input").addEventListener("change",this.basketnum);
            this.basket_list.appendChild(tr);
        });
        this.basketprice();
    }

    basketnum=e=>{
        let target = e.target,val = e.target.value,id = e.target.getAttribute("data-id");
        if(val < 1) target.value = 1;
        this.maplist[id].num = target.value;
        this.basketprice();
    }
    
    basket_del=e=>{
        let id = e.target.getAttribute("data-id"),idx = "";
        this.basketList.find((x,ix)=>{if(x == id) idx = ix;});
        this.basketList.splice(idx,1);
        this.makeBasket();
    }

    price_type(num){
        let result = num+"",price = "";
        while(1){
            if(result.length < 4) break;
            price = result.substr(result.length-3,3)+","+price;
            result = result.substr(0,result.length -3);
        }
        price = result+","+price;
        price = price.substr(0,price.length-1);
        console.log(price);
        return price;
    }

    dropHandle = e=>{
        let id = e.dataTransfer.getData("id");
        this.basketAdd(id);
    }

    drop = e=>{
        e.preventDefault();
    }

    drag =e=>{
        let id = e.target.getAttribute("data-id");
        e.dataTransfer.setData("id",id);
    }

    makeItem({product_name,id,photo,brand,price}){
        let card = document.createElement("div");
        card.innerHTML = `<div class="card store_card">
                            <img src="resources/images/${photo}" data-id="${id}" alt="store_item_img" title="store_item_img" draggable class="card-img">
                            <div class="card-body border-top">
                                <h5 class="card-title">${product_name}</h5>
                                <p class="card-subtitle text-muted">${brand}</p>
                                <p class="card-text text-right pt-2">${price} 원</p>
                            </div>
                        </div>`;
        card.firstChild.querySelector("img").addEventListener("dragstart",this.drag);
        this.item_list.appendChild(card.firstChild);
    }
}

window.onload = () =>{
    let a = new store();
}