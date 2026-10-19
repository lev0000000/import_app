import { Routes } from '@angular/router';
import { ImportPage } from './page/import-page/import-page';
import { Home } from './page/home/home';
import { Products } from './page/products/products';
import { ProductPage } from './pages/product-page/product-page';
import { ImportPageStatus } from './page/import-page-status/import-page-status';
import { ProductItem } from './page/product-item/product-item';

export const routes: Routes = [
  { path: '', component: Home },
  { path: 'products', component: Products },
  { path: 'products/:id', component: ProductItem},
  { path: 'import', component: ImportPage },
  { path: 'import/:id', component: ImportPageStatus },
];