const content = document.getElementById('guide-content');
const subnav = document.getElementById('guide-subnav');
const contentAnchorNodes = content.querySelectorAll("h2");
const activeNavItem = subnav.querySelector('.active');

let titles = [];

contentAnchorNodes.forEach((node) => {
    titles.push({
        text: node.textContent.replace(' #', ''),
        href: node.querySelector('a').getAttribute('href')
    });
});

if (titles.length > 0) {
    let ul = document.createElement('ul');
    ul.className = 'subnav';

    titles.forEach((item) => {
        let li = document.createElement('li');
        let a = document.createElement('a');
        let text = document.createTextNode(item.text);
        a.href = item.href;

        a.appendChild(text);
        li.appendChild(a);
        ul.appendChild(li);
    });

    activeNavItem.appendChild(ul);
}
