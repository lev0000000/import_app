
export interface Product {
  id: number;
  external_code: string;
  name: string;
  description: string;
  price: number;
  discount: number;
  attributes: {
    key: string;
    value: string;
  }[];
  images: {
    url: string;
    path: string;
  }[];
}

export const MOCK_PRODUCTS: Product[] = [
  {
    id: 1,
    external_code: 'PRD-1001',
    name: 'Ноутбук Lenovo IdeaPad Slim 3',
    description: 'Ноутбук 15.6", Ryzen 5, 16 ГБ RAM, SSD 512 ГБ',
    price: 54990,
    discount: 15,
    attributes: [
      { key: 'Бренд', value: 'Lenovo' },
      { key: 'Цвет', value: 'Серый' },
      { key: 'Оперативная память', value: '16 ГБ' },
    ],
    images: [],
  },
  {
    id: 2,
    external_code: 'PRD-1002',
    name: 'Смартфон Samsung Galaxy A55',
    description: 'Смартфон с AMOLED-дисплеем и памятью 256 ГБ',
    price: 32990,
    discount: 10,
    attributes: [
      { key: 'Бренд', value: 'Samsung' },
      { key: 'Цвет', value: 'Синий' },
      { key: 'Память', value: '256 ГБ' },
    ],
    images: [],
  },
  {
    id: 3,
    external_code: 'PRD-1003',
    name: 'Монитор LG UltraGear 27"',
    description: 'Игровой IPS-монитор, 144 Гц, разрешение QHD',
    price: 24990,
    discount: 20,
    attributes: [
      { key: 'Бренд', value: 'LG' },
      { key: 'Диагональ', value: '27 дюймов' },
      { key: 'Частота', value: '144 Гц' },
    ],
    images: [],
  },
  {
    id: 4,
    external_code: 'PRD-1004',
    name: 'Клавиатура Logitech MX Keys',
    description: 'Беспроводная клавиатура с подсветкой',
    price: 10990,
    discount: 5,
    attributes: [
      { key: 'Бренд', value: 'Logitech' },
      { key: 'Подключение', value: 'Bluetooth' },
    ],
    images: [],
  },
  {
    id: 5,
    external_code: 'PRD-1005',
    name: 'Мышь Razer DeathAdder V3',
    description: 'Игровая проводная мышь с оптическим сенсором',
    price: 6990,
    discount: 0,
    attributes: [
      { key: 'Бренд', value: 'Razer' },
      { key: 'Тип', value: 'Проводная' },
    ],
    images: [],
  },
  {
    id: 6,
    external_code: 'PRD-1006',
    name: 'Наушники Sony WH-1000XM5',
    description: 'Беспроводные наушники с активным шумоподавлением',
    price: 29990,
    discount: 12,
    attributes: [
      { key: 'Бренд', value: 'Sony' },
      { key: 'Тип', value: 'Полноразмерные' },
    ],
    images: [],
  },
  {
    id: 7,
    external_code: 'PRD-1007',
    name: 'SSD Samsung 990 PRO 1 ТБ',
    description: 'NVMe SSD PCIe 4.0 для компьютеров и ноутбуков',
    price: 12990,
    discount: 8,
    attributes: [
      { key: 'Бренд', value: 'Samsung' },
      { key: 'Объём', value: '1 ТБ' },
    ],
    images: [],
  },
  {
    id: 8,
    external_code: 'PRD-1008',
    name: 'Веб-камера Logitech C920',
    description: 'Веб-камера Full HD 1080p со встроенным микрофоном',
    price: 7990,
    discount: 0,
    attributes: [
      { key: 'Бренд', value: 'Logitech' },
      { key: 'Разрешение', value: '1920×1080' },
    ],
    images: [],
  },
];
