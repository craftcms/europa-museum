const content = document.getElementById('guide-content');
const subnav = document.getElementById('guide-subnav');
const contentAnchorNodes = content.querySelectorAll("h2");
const activeNavItem = subnav.querySelector('.active');

let headings = [];
let subnavItems = [];

// Highlight currently-active *child* nav item depending on what’s in view
const updateSubnavHighlight = () => {
    contentAnchorNodes.forEach((v,i)=> {
        let rect = v.getBoundingClientRect().y

        if (rect < ((window.innerHeight / 2) - 100)){
            subnavItems.forEach(v=> v.classList.remove('active'))
            subnavItems[i].classList.add('active')
        }
    })
}

// Create links for h2 headings for use in subnav
contentAnchorNodes.forEach((node) => {
    headings.push({
        text: node.textContent.replace(' #', ''),
        href: node.querySelector('a').getAttribute('href')
    });
});

if (headings.length > 0) {
    // Create the subnav menu for h2 anchors
    let ul = document.createElement('ul');
    ul.className = 'subnav';

    headings.forEach((item) => {
        let li = document.createElement('li');
        let a = document.createElement('a');
        let text = document.createTextNode(item.text);
        a.href = item.href;

        a.appendChild(text);
        li.appendChild(a);
        ul.appendChild(li);

        subnavItems.push(li);
    });

    activeNavItem.appendChild(ul);

    // Listen on scroll and keep the right subnav item highlighted
    window.addEventListener('scroll', updateSubnavHighlight);

    // Do a quick highlight now, before any scrolling
    updateSubnavHighlight();
}


