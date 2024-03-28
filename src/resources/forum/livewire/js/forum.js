import { formatDistance } from 'date-fns';
import "@melloware/coloris/dist/coloris.css";
import Coloris from "@melloware/coloris";

window.dateFormatDistance = formatDistance;
window.Coloris = Coloris;
window.Coloris.init();
