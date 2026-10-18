import { ProductAttribute } from './product-attribute';
import { ProductImage } from './product-image';

export interface Product {
  id: number;
  external_code: string;
  name: string;
  description: string;
  price: number;
  discount: number;
  attributes?: ProductAttribute[];
  images?: ProductImage[];
}