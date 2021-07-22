function bindAll(self, toBind) {
    const l = toBind.length;

    for (let i = 0; i < l; i += 1) {
        self[toBind[i]] = self[toBind[i]].bind(self);
    }
}

export default bindAll;
