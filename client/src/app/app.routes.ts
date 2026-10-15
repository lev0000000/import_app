import { Routes } from '@angular/router';
import { ImportPage } from './page/import-page/import-page';
import { Home } from './page/home/home';
import { Products } from './page/products/products';
import { ProductPage } from './pages/product-page/product-page';

export const routes: Routes = [
  { path: '', component: Home },
  { path: 'products', component: Products },
  { path: 'products/:id', component: ProductPage },
  { path: 'import', component: ImportPage },
];