# Task

# Prompt
- You have to change the react components of project (@/resources/js/Pages/) following the design below in html and tailwind.
- Review only style, do not touch animations or logic
- Use tailwind for styling
- Change only the components that i am mentioning and components related to them.

## Selection View front end

- Path: /resources/js/Pages/Home/Views/SelectionView.jsx

### Html + Tailwind

```html
<div class="w-[1080px] h-[1920px] relative overflow-hidden">
    <div class="left-[227px] top-[240px] absolute text-center justify-start"><span class="text-neutral-700 text-7xl font-bold font-['Proxima_Nova'] leading-[76px]">BENVENUTO AL</span><span class="text-black text-7xl font-bold font-['Proxima_Nova'] leading-[76px]">   </span><span class="text-rose-700 text-7xl font-bold font-['Proxima_Nova'] leading-[76px]">TOTEM ARISTON</span></div>
    <div class="w-[760px] h-60 px-14 py-16 left-[163px] top-[725px] absolute bg-rose-700 rounded-[30px] inline-flex justify-between items-center overflow-hidden">
        <img class="w-96 h-24" src="https://placehold.co/402x99" />
        <div class="w-20 h-20 relative overflow-hidden">
            <div class="w-5 h-11 left-[32.63px] top-[22px] absolute outline outline-[5px] outline-offset-[-2.50px] outline-white"></div>
        </div>
    </div>
    <div class="w-[760px] h-60 px-14 py-16 left-[164px] top-[991px] absolute bg-sky-900 rounded-[30px] inline-flex justify-between items-center overflow-hidden">
        <img class="w-[471px] h-20" src="https://placehold.co/471x87" />
        <div class="w-20 h-20 relative overflow-hidden">
            <div class="w-5 h-11 left-[32.63px] top-[22px] absolute outline outline-[5px] outline-offset-[-2.50px] outline-white"></div>
        </div>
    </div>
    <div class="w-[760px] h-60 px-14 py-16 left-[164px] top-[1257px] absolute bg-neutral-500 rounded-[30px] inline-flex justify-between items-center overflow-hidden">
        <img class="w-80 h-24" src="https://placehold.co/344x104" />
        <div class="w-20 h-20 relative overflow-hidden">
            <div class="w-5 h-11 left-[32.63px] top-[22px] absolute outline outline-[5px] outline-offset-[-2.50px] outline-white"></div>
        </div>
    </div>
    <div class="left-[407px] top-[600px] absolute text-center justify-start text-neutral-700 text-4xl font-normal font-['Proxima_Nova']">SCEGLI IL BRAND</div>
    <div class="w-[953px] h-10 left-[63px] top-0 absolute bg-rose-700 rounded-bl-[20px] rounded-br-[20px]"></div>
    <img class="w-60 h-16 left-[418px] top-[1790px] absolute" src="https://placehold.co/244x63" />
</div>
```
- [ ] Selection View done
- [ ] Verification of layout done 

## Dashboard View front end

- Path: /resources/js/Pages/Home/Views/DashboardView.jsx

### Html + Tailwind

```html
<div class="w-[1080px] h-[1920px] relative overflow-hidden">
    <div class="left-[253px] top-[600px] absolute text-center justify-start text-neutral-700 text-4xl font-normal font-['Proxima_Nova']">SCEGLI LA TUA PROSSIMA ATTIVITÀ</div>
    <div class="w-[953px] h-10 left-[63px] top-0 absolute bg-rose-700 rounded-bl-[20px] rounded-br-[20px]"></div>
    <img class="w-60 h-16 left-[418px] top-[1790px] absolute" src="https://placehold.co/244x63" />
    <div class="w-[771px] px-12 py-16 left-[155px] top-[737px] absolute bg-rose-700 rounded-[30px] inline-flex justify-between items-center overflow-hidden">
        <div class="flex justify-start items-center gap-6">
            <div class="w-12 h-12 relative overflow-hidden">
                <div class="w-8 h-10 left-[8px] top-[4px] absolute outline outline-4 outline-offset-[-2px] outline-white"></div>
                <div class="w-3 h-3 left-[28px] top-[4px] absolute outline outline-4 outline-offset-[-2px] outline-white"></div>
                <div class="w-4 h-0 left-[16px] top-[26px] absolute outline outline-4 outline-offset-[-2px] outline-white"></div>
                <div class="w-4 h-0 left-[16px] top-[34px] absolute outline outline-4 outline-offset-[-2px] outline-white"></div>
                <div class="w-1 h-0 left-[16px] top-[18px] absolute outline outline-4 outline-offset-[-2px] outline-white"></div>
            </div>
            <div class="text-center justify-start text-white text-3xl font-normal font-['Proxima_Nova']">DOCUMENTAZIONE</div>
        </div>
        <div class="w-20 h-20 relative overflow-hidden">
            <div class="w-5 h-11 left-[32.63px] top-[22px] absolute outline outline-[5px] outline-offset-[-2.50px] outline-white"></div>
        </div>
    </div>
    <div class="w-[771px] px-12 py-16 left-[155px] top-[1001px] absolute bg-rose-700 rounded-[30px] inline-flex justify-between items-center overflow-hidden">
        <div class="flex justify-start items-center gap-6">
            <div class="w-12 h-12 relative overflow-hidden">
                <div class="w-10 h-7 left-[4px] top-[6px] absolute outline outline-4 outline-offset-[-2px] outline-white"></div>
                <div class="w-4 h-0 left-[16px] top-[42px] absolute outline outline-4 outline-offset-[-2px] outline-white"></div>
                <div class="w-0 h-2 left-[24px] top-[34px] absolute outline outline-4 outline-offset-[-2px] outline-white"></div>
            </div>
            <div class="text-center justify-start text-white text-3xl font-normal font-['Proxima_Nova']">SIMULATORE</div>
        </div>
        <div class="w-20 h-20 relative overflow-hidden">
            <div class="w-5 h-11 left-[32.63px] top-[22px] absolute outline outline-[5px] outline-offset-[-2.50px] outline-white"></div>
        </div>
    </div>
    <div class="w-[771px] px-12 py-16 left-[155px] top-[1265px] absolute bg-rose-700 rounded-[30px] inline-flex justify-between items-center overflow-hidden">
        <div class="flex justify-start items-center gap-6">
            <div class="w-12 h-12 relative overflow-hidden">
                <div class="w-10 h-10 left-[4px] top-[4px] absolute outline outline-4 outline-offset-[-2px] outline-white"></div>
                <div class="w-3 h-4 left-[20px] top-[16px] absolute outline outline-4 outline-offset-[-2px] outline-white"></div>
            </div>
            <div class="text-center justify-start text-white text-3xl font-normal font-['Proxima_Nova']">QUIZ</div>
        </div>
        <div class="w-20 h-20 relative overflow-hidden">
            <div class="w-5 h-11 left-[32.63px] top-[22px] absolute outline outline-[5px] outline-offset-[-2.50px] outline-white"></div>
        </div>
    </div>
    <img class="w-96 h-24 left-[331px] top-[240px] absolute" src="https://placehold.co/419x103" />
    <div class="left-[131px] top-[56px] absolute text-center justify-start text-rose-700 text-3xl font-semibold font-['Proxima_Nova']">Indietro</div>
    <div class="w-12 h-12 left-[74px] top-[52px] absolute overflow-hidden">
        <div class="w-3 h-6 left-[18px] top-[12px] absolute outline outline-4 outline-offset-[-2px] outline-rose-700"></div>
    </div>
</div>
```
- [ ] Dashboard View done
- [ ] Verification of layout done

## Info View front end

- Path: /resources/js/Pages/Home/Views/InfoView.jsx

### Additional directives

- All that is in this page has to be deleted, in this page will be only a pdf that user can swipe from a pages

### Html + Tailwind

```html
<div class="w-[1080px] h-[1920px] relative overflow-hidden">
    <div class="w-[953px] h-10 left-[63px] top-0 absolute bg-rose-700 rounded-bl-[20px] rounded-br-[20px]"></div>
    <img class="w-60 h-16 left-[418px] top-[1790px] absolute" src="https://placehold.co/244x63" />
    <div class="left-[120px] top-[62px] absolute text-center justify-start text-rose-700 text-3xl font-semibold font-['Proxima_Nova']">Indietro</div>
    <div class="w-12 h-12 left-[63px] top-[58px] absolute overflow-hidden">
        <div class="w-3 h-6 left-[18px] top-[12px] absolute outline outline-4 outline-offset-[-2px] outline-rose-700"></div>
    </div>
</div>
```
- [ ] Info View done
- [ ] Verification of layout done

## Simulator View front end

- Path: /resources/js/Pages/Home/Views/SimulatorView.jsx

### Html + Tailwind

```html
<div class="w-[1080px] h-[1920px] relative overflow-hidden">
    <div class="w-[953px] h-10 left-[63px] top-0 absolute bg-rose-700 rounded-bl-[20px] rounded-br-[20px]"></div>
    <div class="w-[911px] h-14 left-[84px] top-[456px] absolute bg-white rounded-[100px] shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)]"></div>
    <img class="w-60 h-16 left-[418px] top-[1790px] absolute" src="https://placehold.co/244x63" />
    <img class="w-[911px] h-[932px] left-[84px] top-[531px] absolute rounded-[40px] shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)]" src="https://placehold.co/911x932" />
    <div class="left-[383px] top-[474px] absolute text-center justify-start text-black text-xl font-normal font-['Proxima_Nova']">simulatorecontotermico-ariston.com</div>
    <div class="left-[186px] top-[240px] absolute text-center justify-start"><span class="text-neutral-700 text-6xl font-bold font-['Proxima_Nova']">SCOPRI IL </span><span class="text-rose-700 text-6xl font-bold font-['Proxima_Nova']">SIMULATORE</span></div>
    <div class="left-[120px] top-[64px] absolute text-center justify-start text-rose-700 text-3xl font-semibold font-['Proxima_Nova']">Indietro</div>
    <div class="w-12 h-12 left-[63px] top-[60px] absolute overflow-hidden">
        <div class="w-3 h-6 left-[18px] top-[12px] absolute outline outline-4 outline-offset-[-2px] outline-rose-700"></div>
    </div>
</div>
```
- [ ] Simulator View done
- [ ] Verification of layout done

## Quiz View front end

- Path: /resources/js/Pages/Home/Views/QuizView.jsx

### Html + Tailwind

#### Main view

```html
<div class="w-[1080px] h-[1920px] relative overflow-hidden">
    <div class="w-[953px] h-10 left-[63px] top-0 absolute bg-rose-700 rounded-bl-[20px] rounded-br-[20px]"></div>
    <img class="w-60 h-16 left-[418px] top-[1790px] absolute" src="https://placehold.co/244x63" />
    <div class="left-[164px] top-[706px] absolute text-center justify-start"><span class="text-rose-700 text-4xl font-bold font-['Proxima_Nova']">1</span><span class="text-black text-4xl font-normal font-['Proxima_Nova']"> </span><span class="text-black text-2xl font-normal font-['Proxima_Nova']">di 10</span></div>
    <div class="left-[776px] top-[731px] absolute text-right justify-start text-black text-xl font-normal font-['Proxima_Nova']">10% completato</div>
    <div class="w-[771px] px-20 py-16 left-[154px] top-[818px] absolute bg-rose-700 rounded-[30px] shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)] inline-flex flex-col justify-start items-start gap-12 overflow-hidden">
        <div class="w-[485px] justify-start text-white text-5xl font-semibold font-['Proxima_Nova'] leading-10">Il conto termico è un incentivo statale?</div>
        <div class="self-stretch flex flex-col justify-start items-start gap-7">
            <div class="self-stretch px-16 py-12 bg-white rounded-[20px] inline-flex justify-start items-center">
                <div class="justify-start text-rose-700 text-5xl font-semibold font-['Proxima_Nova']">Sì</div>
            </div>
            <div class="self-stretch px-16 py-12 bg-white rounded-[20px] inline-flex justify-start items-center">
                <div class="justify-start text-rose-700 text-5xl font-semibold font-['Proxima_Nova']">No</div>
            </div>
        </div>
    </div>
    <div class="w-[771px] h-6 left-[154px] top-[765px] absolute bg-white rounded-[30px] shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)]"></div>
    <div class="w-20 h-6 left-[154px] top-[765px] absolute bg-rose-700 rounded-[30px]"></div>
    <div class="left-[265px] top-[522px] absolute text-center justify-start text-neutral-700 text-2xl font-bold font-['Proxima_Nova']">Livello 1</div>
    <div class="left-[258px] top-[551px] absolute text-center justify-start text-neutral-700 text-xl font-light font-['Proxima_Nova']">Principiante</div>
    <div class="left-[497px] top-[551px] absolute text-center justify-start text-neutral-700 text-xl font-light font-['Proxima_Nova']">Intermedio</div>
    <div class="left-[737px] top-[551px] absolute text-center justify-start text-neutral-700 text-xl font-light font-['Proxima_Nova']">Avanzato</div>
    <div class="left-[498px] top-[522px] absolute text-center justify-start text-neutral-700 text-2xl font-bold font-['Proxima_Nova']">Livello 2</div>
    <div class="left-[732px] top-[522px] absolute text-center justify-start text-neutral-700 text-2xl font-bold font-['Proxima_Nova']">Livello 3</div>
    <div class="w-[469px] h-3 left-[309px] top-[465px] absolute bg-white rounded-[30px] shadow-[0px_0px_6px_0px_rgba(0,0,0,0.25)] overflow-hidden">
        <div class="w-20 h-3 left-0 top-0 absolute opacity-20 bg-rose-700 rounded-[30px]"></div>
    </div>
    <div class="w-7 h-7 left-[294px] top-[456px] absolute bg-rose-700 rounded-full"></div>
    <div class="w-7 h-7 left-[529px] top-[456px] absolute bg-rose-700 rounded-full"></div>
    <div class="w-7 h-7 left-[763px] top-[456px] absolute bg-rose-700 rounded-full"></div>
    <div class="left-[120px] top-[62px] absolute text-center justify-start text-rose-700 text-3xl font-semibold font-['Proxima_Nova']">Indietro</div>
    <div class="w-12 h-12 left-[63px] top-[58px] absolute overflow-hidden">
        <div class="w-3 h-6 left-[18px] top-[12px] absolute outline outline-4 outline-offset-[-2px] outline-rose-700"></div>
    </div>
    <div class="left-[310px] top-[240px] absolute text-center justify-start"><span class="text-neutral-700 text-6xl font-bold font-['Proxima_Nova']">GIOCA AL </span><span class="text-rose-700 text-6xl font-bold font-['Proxima_Nova']">QUIZ</span></div>
</div>
```
- [ ] Main View done

#### Thank you view

```html
<div class="w-[1080px] h-[1920px] relative overflow-hidden">
    <div class="w-[771px] h-[840px] px-20 py-16 left-[154px] top-[607px] absolute bg-white rounded-[30px] shadow-[0px_0px_100px_-40px_rgba(206,16,44,1.00)] inline-flex flex-col justify-start items-center gap-11 overflow-hidden">
        <div class="text-center justify-start text-rose-700 text-4xl font-semibold font-['Proxima_Nova'] leading-9">HAI TOTALIZZATO 20 PUNTI</div>
        <div class="self-stretch p-12 bg-gray-200 rounded-[30px] flex flex-col justify-start items-start gap-8">
            <div class="w-20 justify-start text-black text-2xl font-semibold font-['Proxima_Nova']">Nome</div>
            <div class="w-[501px] h-28 bg-white rounded-2xl shadow-[0px_0px_2px_0px_rgba(0,0,0,0.25)]"></div>
            <div class="w-36 justify-start text-black text-2xl font-semibold font-['Proxima_Nova']">Cognome</div>
            <div class="w-[501px] h-28 bg-white rounded-2xl shadow-[0px_0px_2px_0px_rgba(0,0,0,0.25)]"></div>
            <div class="w-20 justify-start text-black text-2xl font-semibold font-['Proxima_Nova']">Email</div>
            <div class="w-[501px] h-28 bg-white rounded-2xl shadow-[0px_0px_2px_0px_rgba(0,0,0,0.25)]"></div>
        </div>
    </div>
    <div class="px-24 py-8 left-[409px] top-[1400px] absolute bg-rose-700 rounded-2xl shadow-[0px_0px_2px_0px_rgba(0,0,0,0.25)] inline-flex justify-center items-center overflow-hidden">
        <div class="justify-start text-white text-2xl font-semibold font-['Proxima_Nova']">INVIA</div>
    </div>
    <div class="left-[315px] top-[240px] absolute text-center justify-start text-neutral-700 text-6xl font-bold font-['Proxima_Nova']">COMPLIMENTI!</div>
    <div class="w-[953px] h-10 left-[63px] top-0 absolute bg-rose-700 rounded-bl-[20px] rounded-br-[20px]"></div>
</div>
```
- [ ] Thank you view done

- [ ] Quiz View done
- [ ] Verification of layout done
- [ ] Verification of quiz flow, if all works like before, if not restart to work on this view


# Good luck, i believe in you!!!


