const { contextBridge } = require("electron");

contextBridge.exposeInMainWorld("compoundxDesktop", {
  version: "0.1.0"
});
